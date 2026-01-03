<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured vehicles for homepage
        $featuredRentals = Vehicle::availableForRent()
            ->with('images')
            ->take(6)
            ->get();

        $featuredSales = Vehicle::availableForSale()
            ->with('images')
            ->take(6)
            ->get();

        return view('home', compact('featuredRentals', 'featuredSales'));
    }

    public function setLanguage(Request $request, $language)
    {
        if (in_array($language, ['en', 'am'])) {
            session(['locale' => $language]);
            
            // Update user preference if logged in
            if (auth()->check()) {
                auth()->user()->update(['preferred_language' => $language]);
            }
        }

        return back();
    }
}