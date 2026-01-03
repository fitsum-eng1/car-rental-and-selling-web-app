<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'token',
        'expires_at',
        'used_at',
        'created_by',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    // Relationships
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper methods
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isUsed(): bool
    {
        return !is_null($this->used_at);
    }

    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->isUsed();
    }

    public function markAsUsed(): void
    {
        $this->update(['used_at' => now()]);
    }

    public function getUrl(): string
    {
        return route('payment.link', ['token' => $this->token]);
    }

    public function getRemainingTime(): string
    {
        if ($this->isExpired()) {
            return 'Expired';
        }

        $diff = now()->diffInHours($this->expires_at);
        
        if ($diff < 1) {
            $minutes = now()->diffInMinutes($this->expires_at);
            return $minutes . ' minute' . ($minutes !== 1 ? 's' : '') . ' remaining';
        }
        
        return $diff . ' hour' . ($diff !== 1 ? 's' : '') . ' remaining';
    }

    // Static methods
    public static function generateSecureToken(): string
    {
        return Str::random(64);
    }

    public static function createForBooking(Booking $booking, User $admin): self
    {
        return self::create([
            'booking_id' => $booking->id,
            'token' => self::generateSecureToken(),
            'expires_at' => now()->addHours(48), // 48 hours expiration
            'created_by' => $admin->id,
        ]);
    }

    // Scopes
    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now())
                    ->whereNull('used_at');
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    public function scopeUsed($query)
    {
        return $query->whereNotNull('used_at');
    }
}