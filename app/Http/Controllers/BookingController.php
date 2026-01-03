<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function create(Vehicle $vehicle)
    {
        if (!$vehicle->isAvailableForRent()) {
            return redirect()->route('vehicles.rentals')->with('error', 'Vehicle is not available for rent.');
        }

        return view('bookings.create', compact('vehicle'));
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'pickup_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:pickup_date',
            'driving_option' => 'required|in:self_drive,with_driver',
            'pickup_location' => 'required|string|max:255',
            'pickup_latitude' => 'nullable|numeric|between:-90,90',
            'pickup_longitude' => 'nullable|numeric|between:-180,180',
            'return_location' => 'required|string|max:255',
            'return_latitude' => 'nullable|numeric|between:-90,90',
            'return_longitude' => 'nullable|numeric|between:-180,180',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        // Check availability
        if (!$vehicle->isAvailableForDates($request->pickup_date, $request->return_date)) {
            return back()->withErrors(['pickup_date' => 'Vehicle is not available for selected dates.'])->withInput();
        }

        // Validate driving option
        if ($request->driving_option === 'with_driver' && !$vehicle->with_driver_available) {
            return back()->withErrors(['driving_option' => 'Driver service is not available for this vehicle.'])->withInput();
        }

        if ($request->driving_option === 'self_drive' && !$vehicle->self_drive_available) {
            return back()->withErrors(['driving_option' => 'Self-drive is not available for this vehicle.'])->withInput();
        }

        DB::beginTransaction();
        try {
            // Calculate pricing
            $pickupDate = \Carbon\Carbon::parse($request->pickup_date);
            $returnDate = \Carbon\Carbon::parse($request->return_date);
            $totalDays = $pickupDate->diffInDays($returnDate) + 1;
            
            $dailyRate = $vehicle->rental_price_per_day;
            $driverCost = $request->driving_option === 'with_driver' ? ($vehicle->driver_cost_per_day ?? 0) : 0;
            $subtotal = ($dailyRate * $totalDays) + ($driverCost * $totalDays);
            $taxAmount = $subtotal * 0.15; // 15% tax
            $totalAmount = $subtotal + $taxAmount;

            // Create booking
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'vehicle_id' => $vehicle->id,
                'pickup_date' => $request->pickup_date,
                'return_date' => $request->return_date,
                'total_days' => $totalDays,
                'driving_option' => $request->driving_option,
                'pickup_location' => $request->pickup_location,
                'pickup_latitude' => $request->pickup_latitude,
                'pickup_longitude' => $request->pickup_longitude,
                'return_location' => $request->return_location,
                'return_latitude' => $request->return_latitude,
                'return_longitude' => $request->return_longitude,
                'daily_rate' => $dailyRate,
                'driver_cost' => $driverCost,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'special_requests' => $request->special_requests,
                'status' => 'pending_payment',
            ]);

            // Create payment record
            $payment = Payment::create([
                'payable_type' => Booking::class,
                'payable_id' => $booking->id,
                'user_id' => auth()->id(),
                'amount' => $totalAmount,
                'payment_method' => 'mobile_banking',
                'bank_name' => 'Commercial Bank of Ethiopia',
                'account_number' => '1000123456789',
                'payment_instructions' => "Transfer {$totalAmount} ETB and use reference: " . $booking->booking_reference,
                'status' => 'pending',
            ]);

            AuditLog::log('booking_created', $booking);

            DB::commit();

            return redirect()->route('bookings.payment', $booking)->with('success', 'Booking created successfully! Please complete payment.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to create booking. Please try again.'])->withInput();
        }
    }

    public function payment(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $payment = $booking->payment;
        
        return view('bookings.payment', compact('booking', 'payment'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => 'Cancelled by customer',
        ]);

        AuditLog::log('booking_cancelled', $booking);

        return redirect()->route('dashboard')->with('success', 'Booking cancelled successfully.');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['vehicle.images', 'payment']);

        return view('bookings.show', compact('booking'));
    }
}