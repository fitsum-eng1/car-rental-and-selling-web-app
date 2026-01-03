<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        // Check if user exists and account status
        if (!$user) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        if (!$user->canLogin()) {
            $message = $user->isLocked() ? 'Account is temporarily locked.' : 'Account is suspended.';
            return back()->withErrors(['email' => $message])->withInput();
        }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            // Increment failed attempts
            $user->increment('failed_login_attempts');
            
            // Lock account after 5 failed attempts
            if ($user->failed_login_attempts >= 5) {
                $user->update(['locked_until' => now()->addMinutes(30)]);
                AuditLog::log('account_locked', $user, null, null, 'Account locked due to multiple failed login attempts');
            }

            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        // Reset failed attempts on successful login
        $user->update([
            'failed_login_attempts' => 0,
            'locked_until' => null,
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        Auth::login($user, $request->filled('remember'));
        
        AuditLog::log('user_login', $user);

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'preferred_language' => 'required|in:en,am',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $customerRole = Role::where('name', 'customer')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $customerRole->id,
            'preferred_language' => $request->preferred_language,
            'status' => 'active',
        ]);

        AuditLog::log('user_registered', $user);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome to our platform.');
    }

    public function logout(Request $request)
    {
        AuditLog::log('user_logout');
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}