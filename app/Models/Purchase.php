<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_reference',
        'user_id',
        'vehicle_id',
        'purchase_price',
        'tax_amount',
        'total_amount',
        'status',
        'rejection_reason',
        'notes',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'completed_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($purchase) {
            if (!$purchase->purchase_reference) {
                $purchase->purchase_reference = 'PU-' . strtoupper(Str::random(8));
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

    // Helper methods
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['pending', 'payment_submitted']);
    }

    public function canBeRejected(): bool
    {
        return in_array($this->status, ['pending', 'payment_submitted']);
    }
}