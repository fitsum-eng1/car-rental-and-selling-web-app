<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\AuditLog;
use App\Services\AdminActionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class AdminBookingController extends Controller
{
    protected AdminActionHandler $actionHandler;

    public function __construct(AdminActionHandler $actionHandler)
    {
        $this->actionHandler = $actionHandler;
    }

    public function index(Request $request)
    {
        $query = Booking::with(['user', 'vehicle.images', 'payment']);

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'stuck') {
                // Filter for stuck bookings (pending_payment with no payment record)
                $query->where('status', 'pending_payment')
                      ->whereDoesntHave('payment');
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter by vehicle
        if ($request->filled('vehicle')) {
            $query->where('vehicle_id', $request->vehicle);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('pickup_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('return_date', '<=', $request->end_date);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'vehicle.images', 'payment']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function approve(Request $request, Booking $booking)
    {
        if ($booking->status !== 'pending_approval') {
            return back()->with('error', 'Booking cannot be approved in its current status.');
        }

        $oldStatus = $booking->status;
        $booking->update([
            'status' => 'confirmed',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        AuditLog::log('booking_approved', $booking, ['status' => $oldStatus], ['status' => 'confirmed']);

        return back()->with('success', 'Booking approved successfully.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if (!in_array($booking->status, ['pending_approval', 'confirmed'])) {
            return back()->with('error', 'Booking cannot be rejected in its current status.');
        }

        $oldStatus = $booking->status;
        $booking->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'rejected_by' => auth()->id(),
            'rejected_at' => now(),
        ]);

        AuditLog::log('booking_rejected', $booking, ['status' => $oldStatus], ['status' => 'rejected']);

        return back()->with('success', 'Booking rejected successfully.');
    }

    /**
     * Send payment reminder to customer
     */
    public function sendPaymentReminder(Request $request, Booking $booking)
    {
        try {
            // Validate admin permissions
            if (!$this->actionHandler->validateAdminPermissions(Auth::user(), $booking)) {
                return back()->with('error', 'You do not have permission to perform this action.');
            }

            // Send payment reminder
            $result = $this->actionHandler->sendPaymentReminder($booking, Auth::user());

            if ($result) {
                return back()->with('success', 'Payment reminder sent successfully to ' . $booking->user->email);
            } else {
                return back()->with('error', 'Failed to send payment reminder.');
            }
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a stuck booking
     */
    public function cancelBooking(Request $request, Booking $booking)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        try {
            // Validate admin permissions
            if (!$this->actionHandler->validateAdminPermissions(Auth::user(), $booking)) {
                return back()->with('error', 'You do not have permission to perform this action.');
            }

            // Cancel booking
            $result = $this->actionHandler->cancelBooking(
                $booking, 
                $request->cancellation_reason, 
                Auth::user()
            );

            if ($result) {
                return back()->with('success', 'Booking cancelled successfully.');
            } else {
                return back()->with('error', 'Failed to cancel booking.');
            }
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Mark booking as paid (offline payment)
     */
    public function markAsPaid(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_amount' => 'required|numeric|min:0.01',
        ]);

        try {
            // Validate admin permissions
            if (!$this->actionHandler->validateAdminPermissions(Auth::user(), $booking)) {
                return back()->with('error', 'You do not have permission to perform this action.');
            }

            // Mark as paid
            $result = $this->actionHandler->markAsPaid(
                $booking, 
                (float) $request->payment_amount, 
                Auth::user()
            );

            if ($result) {
                return back()->with('success', 'Booking marked as paid successfully.');
            } else {
                return back()->with('error', 'Failed to mark booking as paid.');
            }
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Generate payment link for booking
     */
    public function generatePaymentLink(Request $request, Booking $booking)
    {
        try {
            // Validate admin permissions
            if (!$this->actionHandler->validateAdminPermissions(Auth::user(), $booking)) {
                return back()->with('error', 'You do not have permission to perform this action.');
            }

            // Generate payment link
            $paymentUrl = $this->actionHandler->generatePaymentLink($booking, Auth::user());

            return back()->with('success', 'Payment link generated successfully.')
                        ->with('payment_link', $paymentUrl);
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Get available actions for a booking (AJAX endpoint)
     */
    public function getAvailableActions(Booking $booking)
    {
        try {
            // Validate admin permissions
            if (!$this->actionHandler->validateAdminPermissions(Auth::user(), $booking)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $actions = $this->actionHandler->getAvailableActions($booking);
            
            return response()->json([
                'actions' => $actions,
                'booking_id' => $booking->id,
                'booking_reference' => $booking->booking_reference,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get action history for a booking (AJAX endpoint)
     */
    public function getActionHistory(Booking $booking)
    {
        try {
            // Validate admin permissions
            if (!$this->actionHandler->validateAdminPermissions(Auth::user(), $booking)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $history = $this->actionHandler->getActionHistory($booking);
            
            return response()->json([
                'history' => $history->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'action_type' => $log->getActionTypeLabel(),
                        'admin_name' => $log->adminUser->name,
                        'notes' => $log->notes,
                        'created_at' => $log->created_at->format('Y-m-d H:i:s'),
                        'action_data' => $log->action_data,
                    ];
                }),
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
