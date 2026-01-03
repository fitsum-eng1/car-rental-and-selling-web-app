<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminVehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('images')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255|unique:vehicles',
            'mileage' => 'required|integer|min:0',
            'fuel_type' => 'required|in:petrol,diesel,hybrid,electric',
            'transmission' => 'required|in:manual,automatic',
            'category' => 'required|in:sedan,suv,pickup,luxury,compact,van',
            'description' => 'nullable|string|max:2000',
            'features' => 'nullable|string',
            'available_for_rent' => 'boolean',
            'rental_price_per_day' => 'nullable|numeric|min:0',
            'self_drive_available' => 'boolean',
            'with_driver_available' => 'boolean',
            'driver_cost_per_day' => 'nullable|numeric|min:0',
            'available_for_sale' => 'boolean',
            'sale_price' => 'nullable|numeric|min:0',
            'condition' => 'nullable|in:excellent,good,fair,poor',
        ]);

        // Validate rental fields
        if ($request->available_for_rent) {
            $request->validate([
                'rental_price_per_day' => 'required|numeric|min:0',
            ]);
            
            if ($request->with_driver_available) {
                $request->validate([
                    'driver_cost_per_day' => 'required|numeric|min:0',
                ]);
            }
        }

        // Validate sale fields
        if ($request->available_for_sale) {
            $request->validate([
                'sale_price' => 'required|numeric|min:0',
                'condition' => 'required|in:excellent,good,fair,poor',
            ]);
        }

        // Process features from textarea (one per line) to array
        $data = $request->all();
        if (!empty($data['features'])) {
            $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));
        } else {
            $data['features'] = [];
        }

        $vehicle = Vehicle::create($data);

        AuditLog::log('vehicle_created', $vehicle);

        return redirect()->route('admin.vehicles.show', $vehicle)
            ->with('success', 'Vehicle created successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('images', 'bookings.user', 'purchases.user');
        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255|unique:vehicles,license_plate,' . $vehicle->id,
            'mileage' => 'required|integer|min:0',
            'fuel_type' => 'required|in:petrol,diesel,hybrid,electric',
            'transmission' => 'required|in:manual,automatic',
            'category' => 'required|in:sedan,suv,pickup,luxury,compact,van',
            'description' => 'nullable|string|max:2000',
            'features' => 'nullable|string',
            'available_for_rent' => 'boolean',
            'rental_price_per_day' => 'nullable|numeric|min:0',
            'self_drive_available' => 'boolean',
            'with_driver_available' => 'boolean',
            'driver_cost_per_day' => 'nullable|numeric|min:0',
            'available_for_sale' => 'boolean',
            'sale_price' => 'nullable|numeric|min:0',
            'condition' => 'nullable|in:excellent,good,fair,poor',
            'status' => 'required|in:available,rented,maintenance,sold,inactive',
            'maintenance_notes' => 'nullable|string|max:1000',
        ]);

        $oldValues = $vehicle->toArray();
        
        // Process features from textarea (one per line) to array
        $data = $request->all();
        if (!empty($data['features'])) {
            $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));
        } else {
            $data['features'] = [];
        }
        
        $vehicle->update($data);

        AuditLog::log('vehicle_updated', $vehicle, $oldValues, $vehicle->fresh()->toArray());

        return redirect()->route('admin.vehicles.show', $vehicle)
            ->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        // Check if vehicle has active bookings
        if ($vehicle->bookings()->whereIn('status', ['confirmed', 'active'])->exists()) {
            return back()->with('error', 'Cannot delete vehicle with active bookings.');
        }

        // Delete associated images
        foreach ($vehicle->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        AuditLog::log('vehicle_deleted', $vehicle);
        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehicle deleted successfully.');
    }

    public function toggleStatus(Vehicle $vehicle)
    {
        $newStatus = $vehicle->status === 'available' ? 'inactive' : 'available';
        
        $oldStatus = $vehicle->status;
        $vehicle->update(['status' => $newStatus]);

        AuditLog::log('vehicle_status_changed', $vehicle, ['status' => $oldStatus], ['status' => $newStatus]);

        return back()->with('success', 'Vehicle status updated successfully.');
    }

    public function uploadImages(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $uploadedCount = 0;
        
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('vehicles', 'public');
            
            VehicleImage::create([
                'vehicle_id' => $vehicle->id,
                'image_path' => $path,
                'alt_text' => $vehicle->full_name,
                'is_primary' => $vehicle->images()->count() === 0 && $index === 0,
                'sort_order' => $vehicle->images()->count() + $index,
            ]);
            
            $uploadedCount++;
        }

        AuditLog::log('vehicle_images_uploaded', $vehicle, null, ['count' => $uploadedCount]);

        return back()->with('success', "{$uploadedCount} images uploaded successfully.");
    }

    public function deleteImage(VehicleImage $image)
    {
        $vehicle = $image->vehicle;
        
        // Delete file from storage
        Storage::disk('public')->delete($image->image_path);
        
        $wasPrimary = $image->is_primary;
        $image->delete();

        // If this was the primary image, make the first remaining image primary
        if ($wasPrimary) {
            $firstImage = $vehicle->images()->first();
            if ($firstImage) {
                $firstImage->update(['is_primary' => true]);
            }
        }

        AuditLog::log('vehicle_image_deleted', $vehicle);

        return back()->with('success', 'Image deleted successfully.');
    }
}