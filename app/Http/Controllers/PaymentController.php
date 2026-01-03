<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentLink;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function submit(Request $request, Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$payment->canBeVerified()) {
            return back()->with('error', 'Payment cannot be submitted at this time.');
        }

        $request->validate([
            'transaction_reference' => 'required|string|max:255',
            'transaction_date' => 'required|date|before_or_equal:today',
            'transaction_proof' => 'nullable|string|max:1000',
        ]);

        $payment->update([
            'transaction_reference' => $request->transaction_reference,
            'transaction_date' => $request->transaction_date,
            'transaction_proof' => $request->transaction_proof,
            'status' => 'submitted',
        ]);

        AuditLog::log('payment_submitted', $payment);

        return back()->with('success', 'Payment details submitted successfully! We will verify your payment within 24 hours.');
    }

    public function status(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        // Load related data
        $payment->load(['payable.vehicle.images']);

        return view('payments.status', compact('payment'));
    }

    public function statusApi(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        return response()->json([
            'status' => $payment->status,
            'message' => $this->getStatusMessage($payment->status),
            'verified_at' => $payment->verified_at?->format('Y-m-d H:i:s'),
        ]);
    }

    private function getStatusMessage($status)
    {
        return match($status) {
            'pending' => 'Payment is pending. Please complete the bank transfer.',
            'submitted' => 'Payment details submitted. Awaiting verification.',
            'verified' => 'Payment verified successfully!',
            'rejected' => 'Payment was rejected. Please contact support.',
            'expired' => 'Payment has expired. Please create a new booking/purchase.',
            default => 'Unknown status',
        };
    }

    /**
     * Handle payment link access
     */
    public function paymentLink(Request $request, string $token)
    {
        // Find the payment link by token
        $paymentLink = PaymentLink::where('token', $token)->first();

        if (!$paymentLink) {
            abort(404, 'Payment link not found.');
        }

        // Check if link is valid
        if (!$paymentLink->isValid()) {
            if ($paymentLink->isExpired()) {
                return view('payments.link-expired', compact('paymentLink'));
            }
            
            if ($paymentLink->isUsed()) {
                return view('payments.link-used', compact('paymentLink'));
            }
        }

        // Load booking with related data
        $booking = $paymentLink->booking;
        $booking->load(['user', 'vehicle.images']);

        // Check if booking still needs payment
        if (!$booking->isStuck()) {
            return view('payments.link-no-longer-needed', compact('paymentLink', 'booking'));
        }

        // Mark link as used if user proceeds to payment
        if ($request->has('proceed')) {
            $paymentLink->markAsUsed();
            
            // Redirect to booking payment page
            return redirect()->route('bookings.payment', $booking);
        }

        // Show payment link landing page
        return view('payments.link-landing', compact('paymentLink', 'booking'));
    }
}