<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function rentals(Request $request)
    {
        $query = Vehicle::availableForRent()->with('images');

        // Apply filters
        if ($request->filled('make')) {
            $query->byMake($request->make);
        }

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->priceRange($request->min_price, $request->max_price, 'rental');
        }

        if ($request->filled('pickup_date') && $request->filled('return_date')) {
            $pickupDate = $request->pickup_date;
            $returnDate = $request->return_date;
            
            $query->whereDoesntHave('bookings', function ($q) use ($pickupDate, $returnDate) {
                $q->where('status', '!=', 'cancelled')
                  ->where(function ($subQ) use ($pickupDate, $returnDate) {
                      $subQ->whereBetween('pickup_date', [$pickupDate, $returnDate])
                           ->orWhereBetween('return_date', [$pickupDate, $returnDate])
                           ->orWhere(function ($dateQ) use ($pickupDate, $returnDate) {
                               $dateQ->where('pickup_date', '<=', $pickupDate)
                                     ->where('return_date', '>=', $returnDate);
                           });
                  });
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        if ($sortBy === 'price') {
            $query->orderBy('rental_price_per_day', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $vehicles = $query->paginate(12);

        // Get filter options
        $makes = Vehicle::availableForRent()->distinct()->pluck('make');
        $categories = Vehicle::availableForRent()->distinct()->pluck('category');

        return view('vehicles.rentals', compact('vehicles', 'makes', 'categories'));
    }

    public function sales(Request $request)
    {
        $query = Vehicle::availableForSale()->with('images');

        // Apply filters
        if ($request->filled('make')) {
            $query->byMake($request->make);
        }

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('year_from') && $request->filled('year_to')) {
            $query->whereBetween('year', [$request->year_from, $request->year_to]);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->priceRange($request->min_price, $request->max_price, 'sale');
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        if ($sortBy === 'price') {
            $query->orderBy('sale_price', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $vehicles = $query->paginate(12);

        // Get filter options
        $makes = Vehicle::availableForSale()->distinct()->pluck('make');
        $categories = Vehicle::availableForSale()->distinct()->pluck('category');
        $years = range(date('Y'), date('Y') - 20);

        return view('vehicles.sales', compact('vehicles', 'makes', 'categories', 'years'));
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('images');
        
        // Check if vehicle is available
        if (!$vehicle->isAvailableForRent() && !$vehicle->isAvailableForSale()) {
            abort(404);
        }

        // Get similar vehicles
        $similarVehicles = Vehicle::where('id', '!=', $vehicle->id)
            ->where('make', $vehicle->make)
            ->where(function ($query) {
                $query->where('available_for_rent', true)
                      ->orWhere('available_for_sale', true);
            })
            ->with('images')
            ->take(4)
            ->get();

        return view('vehicles.show', compact('vehicle', 'similarVehicles'));
    }

    public function checkAvailability(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'pickup_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:pickup_date',
        ]);

        $isAvailable = $vehicle->isAvailableForDates(
            $request->pickup_date,
            $request->return_date
        );

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Vehicle is available for selected dates' : 'Vehicle is not available for selected dates'
        ]);
    }
}