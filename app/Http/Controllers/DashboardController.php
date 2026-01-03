<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Debug: Log current user info
        \Log::info('Dashboard accessed by user', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email
        ]);

        // Get user's bookings
        $bookings = $user->bookings()
            ->with(['vehicle.images', 'payment'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get user's purchases
        $purchases = $user->purchases()
            ->with(['vehicle.images', 'payment'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Statistics
        $stats = [
            'total_bookings' => $user->bookings()->count(),
            'active_bookings' => $user->bookings()->whereIn('status', ['confirmed', 'active', 'paid'])->count(),
            'completed_bookings' => $user->bookings()->where('status', 'completed')->count(),
            'total_purchases' => $user->purchases()->count(),
            'completed_purchases' => $user->purchases()->where('status', 'completed')->count(),
        ];

        // Debug: Log statistics
        \Log::info('Dashboard statistics calculated', [
            'user_id' => $user->id,
            'stats' => $stats,
            'bookings_count' => $bookings->count(),
            'purchases_count' => $purchases->count()
        ]);

        return view('dashboard.index', compact('bookings', 'purchases', 'stats'));
    }

    public function bookings()
    {
        $bookings = auth()->user()->bookings()
            ->with(['vehicle.images', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.bookings', compact('bookings'));
    }

    public function purchases()
    {
        $purchases = auth()->user()->purchases()
            ->with(['vehicle.images', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.purchases', compact('purchases'));
    }

    public function profile()
    {
        return view('dashboard.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . auth()->id(),
            'preferred_language' => 'required|in:en,am',
        ]);

        auth()->user()->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'preferred_language' => $request->preferred_language,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8|different:current_password',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}