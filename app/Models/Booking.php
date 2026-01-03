<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'user_id',
        'vehicle_id',
        'pickup_date',
        'return_date',
        'total_days',
        'driving_option',
        'pickup_location',
        'pickup_latitude',
        'pickup_longitude',
        'return_location',
        'return_latitude',
        'return_longitude',
        'daily_rate',
        'driver_cost',
        'subtotal',
        'tax_amount',
        'total_amount',
        'status',
        'cancellation_reason',
        'cancelled_at',
        'special_requests',
        'payment_reminder_sent_at',
        'payment_reminder_count',
        'auto_cancel_warning_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'pickup_date' => 'date',
            'return_date' => 'date',
            'daily_rate' => 'decimal:2',
            'driver_cost' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'pickup_latitude' => 'decimal:8',
            'pickup_longitude' => 'decimal:8',
            'return_latitude' => 'decimal:8',
            'return_longitude' => 'decimal:8',
            'cancelled_at' => 'datetime',
            'payment_reminder_sent_at' => 'datetime',
            'auto_cancel_warning_sent_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            if (!$booking->booking_reference) {
                $booking->booking_reference = 'BK-' . strtoupper(Str::random(8));
            }
        });
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function payment(): MorphOne
    {
        return $this->morphOne(Payment::class, 'payable');
    }

    public function adminActionLogs(): HasMany
    {
        return $this->hasMany(AdminActionLog::class);
    }

    public function paymentLinks(): HasMany
    {
        return $this->hasMany(PaymentLink::class);
    }

    // Helper methods
    public function calculateTotalDays(): int
    {
        return $this->pickup_date->diffInDays($this->return_date) + 1;
    }

    public function calculateSubtotal(): float
    {
        $rentalCost = $this->daily_rate * $this->total_days;
        $driverCost = $this->driving_option === 'with_driver' ? ($this->driver_cost * $this->total_days) : 0;
        return $rentalCost + $driverCost;
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending_payment', 'paid', 'confirmed']) && 
               $this->pickup_date->isFuture();
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isPaid(): bool
    {
        return in_array($this->status, ['paid', 'confirmed', 'active', 'completed']);
    }

    // Stuck booking detection methods
    public function isStuck(): bool
    {
        return $this->status === 'pending_payment' && is_null($this->payment);
    }

    public function getStuckAge(): int
    {
        if (!$this->isStuck()) {
            return 0;
        }
        
        return $this->created_at->diffInHours(now());
    }

    public function getUrgencyLevel(): string
    {
        $ageInHours = $this->getStuckAge();
        
        if ($ageInHours >= 168) { // 7 days
            return 'critical';
        } elseif ($ageInHours >= 72) { // 3 days
            return 'urgent';
        } elseif ($ageInHours >= 48) { // 2 days
            return 'warning';
        }
        
        return 'normal';
    }

    // Payment reminder methods
    public function canSendReminder(): bool
    {
        if (!$this->isStuck()) {
            return false;
        }
        
        // Can't send reminder if one was sent in the last 24 hours
        if ($this->payment_reminder_sent_at && 
            $this->payment_reminder_sent_at->diffInHours(now()) < 24) {
            return false;
        }
        
        return true;
    }

    public function shouldAutoCancel(): bool
    {
        return $this->isStuck() && $this->getStuckAge() >= 168; // 7 days
    }

    public function shouldFlagForReview(): bool
    {
        return $this->isStuck() && $this->getStuckAge() >= 72; // 3 days
    }

    public function shouldSendPreCancellationWarning(): bool
    {
        return $this->isStuck() && 
               $this->getStuckAge() >= 144 && // 6 days
               is_null($this->auto_cancel_warning_sent_at);
    }

    // Scopes for stuck booking queries
    public function scopeStuck($query)
    {
        return $query->where('status', 'pending_payment')
                    ->whereDoesntHave('payment');
    }

    public function scopeStuckOlderThan($query, int $hours)
    {
        return $query->stuck()
                    ->where('created_at', '<=', now()->subHours($hours));
    }

    public function scopeUrgent($query)
    {
        return $query->stuckOlderThan(72);
    }

    public function scopeCritical($query)
    {
        return $query->stuckOlderThan(168);
    }
}