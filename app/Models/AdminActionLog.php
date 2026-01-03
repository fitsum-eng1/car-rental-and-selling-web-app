<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminActionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'admin_user_id',
        'action_type',
        'action_data',
        'notes',
    ];

    protected $casts = [
        'action_data' => 'json',
    ];

    // Action type constants
    const ACTION_SEND_REMINDER = 'send_reminder';
    const ACTION_CANCEL_BOOKING = 'cancel_booking';
    const ACTION_MARK_AS_PAID = 'mark_as_paid';
    const ACTION_GENERATE_PAYMENT_LINK = 'generate_payment_link';
    const ACTION_AUTO_CANCEL = 'auto_cancel';
    const ACTION_AUTO_FLAG = 'auto_flag';

    // Relationships
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    // Helper methods
    public function getActionTypeLabel(): string
    {
        return match($this->action_type) {
            self::ACTION_SEND_REMINDER => 'Payment Reminder Sent',
            self::ACTION_CANCEL_BOOKING => 'Booking Cancelled',
            self::ACTION_MARK_AS_PAID => 'Marked as Paid',
            self::ACTION_GENERATE_PAYMENT_LINK => 'Payment Link Generated',
            self::ACTION_AUTO_CANCEL => 'Auto-Cancelled',
            self::ACTION_AUTO_FLAG => 'Auto-Flagged for Review',
            default => ucwords(str_replace('_', ' ', $this->action_type)),
        };
    }

    public function isDestructiveAction(): bool
    {
        return in_array($this->action_type, [
            self::ACTION_CANCEL_BOOKING,
            self::ACTION_AUTO_CANCEL,
        ]);
    }
}