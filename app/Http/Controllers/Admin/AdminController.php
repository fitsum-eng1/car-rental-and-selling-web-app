<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Purchase;
use App\Models\Payment;
use App\Models\ContactMessage;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        try {
            // Initialize stuck booking detector
            $stuckBookingDetector = new \App\Services\StuckBookingDetector();
            $stuckBookingStats = $stuckBookingDetector->getDashboardStats();

            // Statistics with safe defaults
            $stats = [
                'total_users' => User::count(),
                'total_vehicles' => Vehicle::count(),
                'total_bookings' => Booking::count(),
                'total_purchases' => Purchase::count(),
                'pending_payments' => Payment::whereIn('status', ['pending', 'submitted'])->count(),
                'new_messages' => ContactMessage::where('status', 'new')->count(),
                'active_bookings' => Booking::where('status', 'active')->count(),
                'monthly_revenue' => 0, // Simplified for now
                'stuck_bookings' => $stuckBookingStats['total_stuck'],
                'critical_stuck_bookings' => $stuckBookingStats['critical_count'],
                'oldest_stuck_booking_days' => $stuckBookingStats['oldest_age_days'],
            ];

            // Recent activities with safe queries
            $recentBookings = Booking::with(['user', 'vehicle'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $recentPurchases = Purchase::with(['user', 'vehicle'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $pendingPayments = Payment::with(['user'])
                ->whereIn('status', ['pending', 'submitted'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            // Get stuck bookings for dashboard display
            $stuckBookings = $stuckBookingDetector->getStuckBookings()->take(5);

            return view('admin.dashboard', compact('stats', 'recentBookings', 'recentPurchases', 'pendingPayments', 'stuckBookings', 'stuckBookingStats'));
        } catch (\Exception $e) {
            // Fallback with empty data
            $stats = [
                'total_users' => 0,
                'total_vehicles' => 0,
                'total_bookings' => 0,
                'total_purchases' => 0,
                'pending_payments' => 0,
                'new_messages' => 0,
                'active_bookings' => 0,
                'monthly_revenue' => 0,
                'stuck_bookings' => 0,
                'critical_stuck_bookings' => 0,
                'oldest_stuck_booking_days' => 0,
            ];

            $recentBookings = collect();
            $recentPurchases = collect();
            $pendingPayments = collect();
            $stuckBookings = collect();
            $stuckBookingStats = [
                'total_stuck' => 0,
                'critical_count' => 0,
                'urgent_count' => 0,
                'warning_count' => 0,
                'normal_count' => 0,
                'oldest_age_hours' => 0,
                'oldest_age_days' => 0,
            ];

            return view('admin.dashboard', compact('stats', 'recentBookings', 'recentPurchases', 'pendingPayments', 'stuckBookings', 'stuckBookingStats'));
        }
    }

    public function payments()
    {
        $payments = Payment::with(['payable', 'user', 'verifiedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function showPayment(Payment $payment)
    {
        $payment->load(['payable.vehicle.images', 'user', 'verifiedBy']);
        
        return view('admin.payments.show', compact('payment'));
    }

    public function verifyPayment(Request $request, Payment $payment)
    {
        if (!$payment->canBeVerified()) {
            return back()->with('error', 'Payment cannot be verified at this time.');
        }

        $payment->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        // Update related booking/purchase status
        if ($payment->payable_type === 'App\Models\Booking') {
            $payment->payable->update(['status' => 'confirmed']);
        } elseif ($payment->payable_type === 'App\Models\Purchase') {
            $payment->payable->update(['status' => 'verified']);
            // Mark vehicle as sold if it's a purchase
            $payment->payable->vehicle->update(['is_sold' => true, 'status' => 'sold']);
        }

        // Email notifications disabled

        AuditLog::log('payment_verified', $payment);

        return back()->with('success', 'Payment verified successfully.');
    }

    public function rejectPayment(Request $request, Payment $payment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $payment->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        // Update related booking/purchase status to rejected
        if ($payment->payable_type === 'App\Models\Booking') {
            $payment->payable->update([
                'status' => 'cancelled',
                'cancellation_reason' => 'Payment rejected: ' . $request->rejection_reason,
                'cancelled_at' => now(),
            ]);
        } elseif ($payment->payable_type === 'App\Models\Purchase') {
            $payment->payable->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
            ]);
        }

        // Email notifications disabled

        AuditLog::log('payment_rejected', $payment, null, ['reason' => $request->rejection_reason]);

        return back()->with('success', 'Payment rejected successfully.');
    }

    public function messages()
    {
        $messages = ContactMessage::with('repliedBy')
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    public function showMessage(ContactMessage $message)
    {
        $message->markAsRead();
        return view('admin.messages.show', compact('message'));
    }

    public function replyMessage(Request $request, ContactMessage $message)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:2000',
        ]);

        $message->update([
            'admin_reply' => $request->admin_reply,
            'replied_by' => auth()->id(),
            'replied_at' => now(),
            'status' => 'replied',
        ]);

        AuditLog::log('message_replied', $message);

        return back()->with('success', 'Reply sent successfully.');
    }

    public function reports()
    {
        $dateRange = request('date_range', 'this_month');
        
        // Calculate date range
        switch ($dateRange) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::today()->endOfDay();
                break;
            case 'this_week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'this_month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'last_month':
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
        }

        // Generate reports
        $reports = [
            'bookings' => [
                'total' => Booking::whereBetween('created_at', [$startDate, $endDate])->count(),
                'completed' => Booking::whereBetween('created_at', [$startDate, $endDate])->where('status', 'completed')->count(),
                'revenue' => Booking::whereBetween('created_at', [$startDate, $endDate])->where('status', 'completed')->sum('total_amount'),
            ],
            'purchases' => [
                'total' => Purchase::whereBetween('created_at', [$startDate, $endDate])->count(),
                'completed' => Purchase::whereBetween('created_at', [$startDate, $endDate])->where('status', 'completed')->count(),
                'revenue' => Purchase::whereBetween('created_at', [$startDate, $endDate])->where('status', 'completed')->sum('total_amount'),
            ],
            'users' => [
                'new_registrations' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
                'active_users' => User::where('status', 'active')->count(),
            ],
            'vehicles' => [
                'total' => Vehicle::count(),
                'available_for_rent' => Vehicle::where('available_for_rent', true)->where('status', 'available')->count(),
                'available_for_sale' => Vehicle::where('available_for_sale', true)->where('is_sold', false)->count(),
            ],
        ];

        // Popular vehicles
        $popularRentals = Vehicle::withCount(['bookings' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])
        ->orderBy('bookings_count', 'desc')
        ->take(5)
        ->get();

        return view('admin.reports', compact('reports', 'popularRentals', 'dateRange', 'startDate', 'endDate'));
    }

    public function exportReport($type, Request $request)
    {
        // Get date range from request or use defaults
        $dateRange = $request->get('date_range', 'this_month');
        
        switch ($dateRange) {
            case 'last_month':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            case 'last_year':
                $startDate = now()->subYear()->startOfYear();
                $endDate = now()->subYear()->endOfYear();
                break;
            default: // this_month
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
        }

        // Generate report data
        $reports = [
            'bookings' => [
                'total' => Booking::whereBetween('created_at', [$startDate, $endDate])->count(),
                'completed' => Booking::whereBetween('created_at', [$startDate, $endDate])->where('status', 'completed')->count(),
                'revenue' => Booking::whereBetween('created_at', [$startDate, $endDate])->where('status', 'completed')->sum('total_amount'),
            ],
            'purchases' => [
                'total' => Purchase::whereBetween('created_at', [$startDate, $endDate])->count(),
                'completed' => Purchase::whereBetween('created_at', [$startDate, $endDate])->where('status', 'completed')->count(),
                'revenue' => Purchase::whereBetween('created_at', [$startDate, $endDate])->where('status', 'completed')->sum('total_amount'),
            ],
            'users' => [
                'new_registrations' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
                'active_users' => User::where('status', 'active')->count(),
            ],
            'vehicles' => [
                'total' => Vehicle::count(),
                'available_for_rent' => Vehicle::where('available_for_rent', true)->where('status', 'available')->count(),
                'available_for_sale' => Vehicle::where('available_for_sale', true)->where('is_sold', false)->count(),
            ],
        ];

        // Popular vehicles
        $popularRentals = Vehicle::withCount(['bookings' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])
        ->orderBy('bookings_count', 'desc')
        ->take(10)
        ->get();

        if ($type === 'csv') {
            return $this->exportCSV($reports, $popularRentals, $startDate, $endDate, $dateRange);
        } elseif ($type === 'pdf') {
            return $this->exportPDF($reports, $popularRentals, $startDate, $endDate, $dateRange);
        }

        return response()->json(['error' => 'Invalid export type'], 400);
    }

    private function exportCSV($reports, $popularRentals, $startDate, $endDate, $dateRange)
    {
        $filename = 'rental_report_' . $dateRange . '_' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($reports, $popularRentals, $startDate, $endDate, $dateRange) {
            $file = fopen('php://output', 'w');
            
            // Report header
            fputcsv($file, ['Car Rental & Sales Report']);
            fputcsv($file, ['Period: ' . $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y')]);
            fputcsv($file, ['Generated: ' . now()->format('M d, Y \a\t g:i A')]);
            fputcsv($file, []); // Empty line
            
            // Summary statistics
            fputcsv($file, ['SUMMARY STATISTICS']);
            fputcsv($file, ['Category', 'Metric', 'Value']);
            fputcsv($file, ['Bookings', 'Total Bookings', $reports['bookings']['total']]);
            fputcsv($file, ['Bookings', 'Completed Bookings', $reports['bookings']['completed']]);
            fputcsv($file, ['Bookings', 'Booking Revenue', '$' . number_format($reports['bookings']['revenue'], 2)]);
            fputcsv($file, ['Purchases', 'Total Purchases', $reports['purchases']['total']]);
            fputcsv($file, ['Purchases', 'Completed Purchases', $reports['purchases']['completed']]);
            fputcsv($file, ['Purchases', 'Sales Revenue', '$' . number_format($reports['purchases']['revenue'], 2)]);
            fputcsv($file, ['Users', 'New Registrations', $reports['users']['new_registrations']]);
            fputcsv($file, ['Users', 'Active Users', $reports['users']['active_users']]);
            fputcsv($file, ['Vehicles', 'Total Vehicles', $reports['vehicles']['total']]);
            fputcsv($file, ['Vehicles', 'Available for Rent', $reports['vehicles']['available_for_rent']]);
            fputcsv($file, ['Vehicles', 'Available for Sale', $reports['vehicles']['available_for_sale']]);
            fputcsv($file, []); // Empty line
            
            // Popular vehicles
            fputcsv($file, ['POPULAR VEHICLES']);
            fputcsv($file, ['Rank', 'Vehicle', 'Make', 'Model', 'Year', 'Daily Rate', 'Bookings Count']);
            foreach ($popularRentals as $index => $vehicle) {
                fputcsv($file, [
                    $index + 1,
                    $vehicle->full_name,
                    $vehicle->make,
                    $vehicle->model,
                    $vehicle->year,
                    '$' . number_format($vehicle->daily_rate, 2),
                    $vehicle->bookings_count
                ]);
            }
            fputcsv($file, []); // Empty line
            
            // Calculated metrics
            fputcsv($file, ['CALCULATED METRICS']);
            fputcsv($file, ['Metric', 'Value']);
            fputcsv($file, ['Total Revenue', '$' . number_format($reports['bookings']['revenue'] + $reports['purchases']['revenue'], 2)]);
            fputcsv($file, ['Booking Completion Rate', ($reports['bookings']['total'] > 0 ? number_format(($reports['bookings']['completed'] / $reports['bookings']['total']) * 100, 1) : 0) . '%']);
            fputcsv($file, ['Purchase Completion Rate', ($reports['purchases']['total'] > 0 ? number_format(($reports['purchases']['completed'] / $reports['purchases']['total']) * 100, 1) : 0) . '%']);
            fputcsv($file, ['Average Booking Value', ($reports['bookings']['completed'] > 0 ? '$' . number_format($reports['bookings']['revenue'] / $reports['bookings']['completed'], 2) : '$0.00')]);
            fputcsv($file, ['Average Purchase Value', ($reports['purchases']['completed'] > 0 ? '$' . number_format($reports['purchases']['revenue'] / $reports['purchases']['completed'], 2) : '$0.00')]);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportPDF($reports, $popularRentals, $startDate, $endDate, $dateRange)
    {
        // For PDF export, we'll create an HTML version and return it
        // In a production environment, you would use a library like DomPDF or wkhtmltopdf
        
        $html = view('admin.reports-pdf', compact('reports', 'popularRentals', 'startDate', 'endDate', 'dateRange'))->render();
        
        $filename = 'rental_report_' . $dateRange . '_' . now()->format('Y-m-d') . '.html';
        
        return response($html, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}