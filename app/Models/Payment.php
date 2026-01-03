<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_reference',
        'payable_type',
        'payable_id',
        'user_id',
        'amount',
        'payment_method',
        'bank_name',
        'account_number',
        'payment_instructions',
        'transaction_reference',
        'transaction_proof',
        'transaction_date',
        'status',
        'rejection_reason',
        'verified_by',
        'verified_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'transaction_date' => 'datetime',
            'verified_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($payment) {
            if (!$payment->payment_reference) {
                $payment->payment_reference = 'PAY-' . strtoupper(Str::random(10));
            }
            
            if (!$payment->expires_at) {
                $payment->expires_at = Carbon::now()->addHours(24);
            }
        });
    }

    // Relationships
    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Helper methods
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    public function canBeVerified(): bool
    {
        return in_array($this->status, ['pending', 'submitted']) && !$this->isExpired();
    }

    public function generateInstructions(): string
    {
        return "Please transfer {$this->amount} ETB to:\n" .
               "Bank: {$this->bank_name}\n" .
               "Account: {$this->account_number}\n" .
               "Reference: {$this->payment_reference}\n" .
               "Then submit your transaction reference number.";
    }
}