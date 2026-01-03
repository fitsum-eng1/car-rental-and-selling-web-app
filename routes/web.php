<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminVehicleController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\CheckoutController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/language/{language}', [HomeController::class, 'setLanguage'])->name('language.set');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Vehicle routes
Route::get('/rent', [VehicleController::class, 'rentals'])->name('vehicles.rentals');
Route::get('/buy', [VehicleController::class, 'sales'])->name('vehicles.sales');
Route::get('/vehicle/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');
Route::post('/vehicle/{vehicle}/check-availability', [VehicleController::class, 'checkAvailability'])->name('vehicles.check-availability');

// Contact routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/bookings', [DashboardController::class, 'bookings'])->name('dashboard.bookings');
    Route::get('/dashboard/purchases', [DashboardController::class, 'purchases'])->name('dashboard.purchases');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::put('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
    Route::put('/dashboard/password', [DashboardController::class, 'changePassword'])->name('dashboard.password.change');

    // Booking routes
    Route::get('/book/{vehicle}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/book/{vehicle}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/booking/{booking}/payment', [BookingController::class, 'payment'])->name('bookings.payment');
    Route::delete('/booking/{booking}', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Purchase routes
    Route::post('/purchase/{vehicle}', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchase/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::get('/purchase/{purchase}/payment', [PurchaseController::class, 'payment'])->name('purchases.payment');

    // Multi-stage Checkout routes
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/vehicle/{vehicle}', [CheckoutController::class, 'stage1'])->name('stage1');
        
        Route::get('/buyer-info', [CheckoutController::class, 'showStage2'])->name('stage2.show');
        Route::post('/buyer-info', [CheckoutController::class, 'processStage2'])->name('stage2.process');
        
        Route::get('/delivery', [CheckoutController::class, 'showStage3'])->name('stage3.show');
        Route::post('/delivery', [CheckoutController::class, 'processStage3'])->name('stage3.process');
        
        Route::get('/payment-method', [CheckoutController::class, 'showStage4'])->name('stage4.show');
        Route::post('/payment-method', [CheckoutController::class, 'processStage4'])->name('stage4.process');
        
        Route::get('/payment-instructions', [CheckoutController::class, 'showStage5'])->name('stage5.show');
        
        Route::post('/complete', [CheckoutController::class, 'complete'])->name('complete');
        Route::get('/status/{purchase}', [CheckoutController::class, 'status'])->name('status');
        Route::get('/cancel', [CheckoutController::class, 'cancel'])->name('cancel');
    });

    // Payment routes
    Route::post('/payment/{payment}/submit', [PaymentController::class, 'submit'])->name('payments.submit');
    Route::get('/payment/{payment}/status', [PaymentController::class, 'status'])->name('payments.status');
    Route::get('/api/payment/{payment}/status', [PaymentController::class, 'statusApi'])->name('payments.status.api');
});

// Payment link route (accessible without authentication)
Route::get('/payment-link/{token}', [PaymentController::class, 'paymentLink'])->name('payment.link');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User management
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Vehicle management
    Route::resource('vehicles', AdminVehicleController::class);
    Route::post('vehicles/{vehicle}/toggle-status', [AdminVehicleController::class, 'toggleStatus'])->name('vehicles.toggle-status');
    Route::post('vehicles/{vehicle}/images', [AdminVehicleController::class, 'uploadImages'])->name('vehicles.upload-images');
    Route::delete('vehicles/images/{image}', [AdminVehicleController::class, 'deleteImage'])->name('vehicles.delete-image');
    
    // Booking management
    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
    Route::post('bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
    
    // Admin booking actions for stuck bookings
    Route::post('bookings/{booking}/send-reminder', [AdminBookingController::class, 'sendPaymentReminder'])->name('bookings.send-reminder');
    Route::post('bookings/{booking}/cancel', [AdminBookingController::class, 'cancelBooking'])->name('bookings.cancel');
    Route::post('bookings/{booking}/mark-paid', [AdminBookingController::class, 'markAsPaid'])->name('bookings.mark-paid');
    Route::post('bookings/{booking}/generate-link', [AdminBookingController::class, 'generatePaymentLink'])->name('bookings.generate-link');
    
    // AJAX endpoints for booking actions
    Route::get('bookings/{booking}/actions', [AdminBookingController::class, 'getAvailableActions'])->name('bookings.actions');
    Route::get('bookings/{booking}/history', [AdminBookingController::class, 'getActionHistory'])->name('bookings.history');
    
    // Payment verification
    Route::get('payments', [AdminController::class, 'payments'])->name('payments.index');
    Route::get('payments/{payment}', [AdminController::class, 'showPayment'])->name('payments.show');
    Route::post('payments/{payment}/verify', [AdminController::class, 'verifyPayment'])->name('payments.verify');
    Route::post('payments/{payment}/reject', [AdminController::class, 'rejectPayment'])->name('payments.reject');
    
    // Reports
    Route::get('reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('reports/export/{type}', [AdminController::class, 'exportReport'])->name('reports.export');
    
    // Contact messages
    Route::get('messages', [AdminController::class, 'messages'])->name('messages.index');
    Route::get('messages/{message}', [AdminController::class, 'showMessage'])->name('messages.show');
    Route::post('messages/{message}/reply', [AdminController::class, 'replyMessage'])->name('messages.reply');
});

// Test email route (temporary)
Route::get('/test-email', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('DriveSphere SMTP test is working! 🚗✨', function ($message) {
            $message->to('drivesphere.official@gmail.com')  // Send to same email for testing
                    ->subject('DriveSphere Email Test - ' . now()->format('Y-m-d H:i:s'));
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Test email sent successfully! Check drivesphere.official@gmail.com inbox.',
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
        
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'timestamp' => now()->format('Y-m-d H:i:s')
        ], 500);
    }
});

// Mailgun setup and testing routes
Route::get('/configure-mailgun', function () {
    return response(file_get_contents(public_path('configure-mailgun.php')))
        ->header('Content-Type', 'text/html');
});

Route::get('/test-mailgun-setup', function () {
    return response(file_get_contents(public_path('test-mailgun-setup.php')))
        ->header('Content-Type', 'text/html');
});