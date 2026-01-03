<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = 'en'; // default

        // Check session first
        if (session()->has('locale')) {
            $locale = session('locale');
        }
        // Then check user preference if logged in
        elseif (auth()->check() && auth()->user()->preferred_language) {
            $locale = auth()->user()->preferred_language;
            session(['locale' => $locale]);
        }

        if (in_array($locale, ['en', 'am'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}