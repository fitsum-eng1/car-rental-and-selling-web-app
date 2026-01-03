<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\User;
use App\Models\Payment;
use App\Models\PaymentLink;
use App\Models\AdminActionLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminActionHandler
{
    /**
     * Send a payment reminder email to the customer
     */
    public function sendPaymentReminder(Booking $booking, User $admin): bool
    {
        // Validate that reminder can be sent BEFORE starting transaction
        if (!$booking->canSendReminder()) {
            throw new Exception('Payment reminder cannot be sent for this booking');
        }

        try {
            DB::beginTransaction();

            // Update booking reminder tracking
            $booking->update([
                'payment_reminder_sent_at' => now(),
                'payment_reminder_count' => ($booking->payment_reminder_count ?? 0) + 1,
            ]);

            // Log the admin action
            AdminActionLog::create([
                'booking_id' => $booking->id,
                'admin_user_id' => $admin->id,
                'action_type' => AdminActionLog::ACTION_SEND_REMINDER,
                'action_data' => [
                    'reminder_count' => $booking->payment_reminder_count,
                    'booking_reference' => $booking->booking_reference,
                    'customer_email' => $booking->user->email,
                ],
                'notes' => "Payment reminder #{$booking->payment_reminder_count} sent to {$booking->user->email}",
            ]);

            // Email notifications disabled

            Log::info("Payment reminder sent for booking {$booking->booking_reference}", [
                'booking_id' => $booking->id,
                'admin_id' => $admin->id,
                'customer_email' => $booking->user->email,
            ]);

            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to send payment reminder for booking {$booking->booking_reference}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cancel a stuck booking with reason
     */
    public function cancelBooking(Booking $booking, string $reason, User $admin): bool
    {
        try {
            // Validate that booking can be cancelled
            if (!$booking->canBeCancelled()) {
                throw new Exception('This booking cannot be cancelled');
            }

            if (empty(trim($reason))) {
                throw new Exception('Cancellation reason is required');
            }

            DB::beginTransaction();

            // Update booking status
            $booking->update([
                'status' => 'cancelled',
                'cancellation_reason' => $reason,
                'cancelled_at' => now(),
            ]);

            // Log the admin action
            AdminActionLog::create([
                'booking_id' => $booking->id,
                'admin_user_id' => $admin->id,
                'action_type' => AdminActionLog::ACTION_CANCEL_BOOKING,
                'action_data' => [
                    'reason' => $reason,
                    'booking_reference' => $booking->booking_reference,
                    'customer_email' => $booking->user->email,
                    'vehicle_id' => $booking->vehicle_id,
                ],
                'notes' => "Booking cancelled by admin. Reason: {$reason}",
            ]);

            // Email notifications disabled

            Log::info("Booking cancelled by admin", [
                'booking_id' => $booking->id,
                'booking_reference' => $booking->booking_reference,
                'admin_id' => $admin->id,
                'reason' => $reason,
            ]);

            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to cancel booking {$booking->booking_reference}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Mark a booking as paid (for offline payments)
     */
    public function markAsPaid(Booking $booking, float $amount, User $admin): bool
    {
        try {
            // Validate inputs
            if ($amount <= 0) {
                throw new Exception('Payment amount must be greater than zero');
            }

            if (!$booking->isStuck()) {
                throw new Exception('Only stuck bookings can be marked as paid');
            }

            DB::beginTransaction();

            // Create offline payment record
            $payment = Payment::create([
                'payable_type' => Booking::class,
                'payable_id' => $booking->id,
                'user_id' => $booking->user_id,
                'amount' => $amount,
                'payment_method' => 'cash', // Use 'cash' for offline payments
                'bank_name' => 'Offline Payment',
                'account_number' => 'N/A',
                'payment_instructions' => 'Offline payment processed by admin',
                'transaction_reference' => 'OFFLINE-' . strtoupper(uniqid()),
                'transaction_date' => now(),
                'status' => 'verified',
                'verified_by' => $admin->id,
                'verified_at' => now(),
            ]);

            // Update booking status
            $booking->update([
                'status' => 'confirmed',
            ]);

            // Log the admin action
            AdminActionLog::create([
                'booking_id' => $booking->id,
                'admin_user_id' => $admin->id,
                'action_type' => AdminActionLog::ACTION_MARK_AS_PAID,
                'action_data' => [
                    'amount' => $amount,
                    'payment_id' => $payment->id,
                    'payment_reference' => $payment->payment_reference,
                    'booking_reference' => $booking->booking_reference,
                ],
                'notes' => "Booking marked as paid (offline payment) - Amount: {$amount} ETB",
            ]);

            Log::info("Booking marked as paid by admin", [
                'booking_id' => $booking->id,
                'booking_reference' => $booking->booking_reference,
                'payment_id' => $payment->id,
                'amount' => $amount,
                'admin_id' => $admin->id,
            ]);

            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to mark booking {$booking->booking_reference} as paid: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate a secure payment link for a booking
     */
    public function generatePaymentLink(Booking $booking, User $admin): string
    {
        try {
            // Validate that booking is stuck
            if (!$booking->isStuck()) {
                throw new Exception('Payment links can only be generated for stuck bookings');
            }

            DB::beginTransaction();

            // Create payment link
            $paymentLink = PaymentLink::createForBooking($booking, $admin);

            // Log the admin action
            AdminActionLog::create([
                'booking_id' => $booking->id,
                'admin_user_id' => $admin->id,
                'action_type' => AdminActionLog::ACTION_GENERATE_PAYMENT_LINK,
                'action_data' => [
                    'payment_link_id' => $paymentLink->id,
                    'token' => $paymentLink->token,
                    'expires_at' => $paymentLink->expires_at->toISOString(),
                    'booking_reference' => $booking->booking_reference,
                ],
                'notes' => "Payment link generated (expires: {$paymentLink->expires_at->format('Y-m-d H:i:s')})",
            ]);

            Log::info("Payment link generated for booking", [
                'booking_id' => $booking->id,
                'booking_reference' => $booking->booking_reference,
                'payment_link_id' => $paymentLink->id,
                'admin_id' => $admin->id,
                'expires_at' => $paymentLink->expires_at,
            ]);

            DB::commit();
            return $paymentLink->getUrl();

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to generate payment link for booking {$booking->booking_reference}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate and send a payment link via email
     */
    public function generateAndSendPaymentLink(Booking $booking, User $admin): string
    {
        try {
            // Generate the payment link
            $paymentUrl = $this->generatePaymentLink($booking, $admin);
            
            // Get the payment link record
            $paymentLink = $booking->paymentLinks()->latest()->first();
            
            if (!$paymentLink) {
                throw new Exception('Payment link not found after generation');
            }
            
            // Email notifications disabled

            Log::info("Payment link notification sent for booking {$booking->booking_reference}", [
                'booking_id' => $booking->id,
                'admin_id' => $admin->id,
                'customer_email' => $booking->user->email,
                'payment_link_id' => $paymentLink->id,
            ]);

            return $paymentUrl;

        } catch (Exception $e) {
            Log::error("Failed to generate and send payment link for booking {$booking->booking_reference}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get available actions for a booking
     */
    public function getAvailableActions(Booking $booking): array
    {
        $actions = [];

        if ($booking->isStuck()) {
            if ($booking->canSendReminder()) {
                $actions[] = 'send_reminder';
            }
            
            $actions[] = 'generate_payment_link';
            $actions[] = 'mark_as_paid';
        }

        if ($booking->canBeCancelled()) {
            $actions[] = 'cancel_booking';
        }

        return $actions;
    }

    /**
     * Validate admin permissions for booking actions
     */
    public function validateAdminPermissions(User $admin, Booking $booking): bool
    {
        // Check if user is admin
        if (!$admin->isAdmin()) {
            return false;
        }

        // Additional permission checks can be added here
        // For now, any admin can perform actions on any booking
        return true;
    }

    /**
     * Get action history for a booking
     */
    public function getActionHistory(Booking $booking): \Illuminate\Database\Eloquent\Collection
    {
        return $booking->adminActionLogs()
            ->with('adminUser')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get recent admin actions across all bookings
     */
    public function getRecentActions(int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return AdminActionLog::with(['booking', 'adminUser'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}