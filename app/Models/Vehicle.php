<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'make',
        'model',
        'year',
        'color',
        'license_plate',
        'mileage',
        'fuel_type',
        'transmission',
        'category',
        'description',
        'features',
        'available_for_rent',
        'rental_price_per_day',
        'self_drive_available',
        'with_driver_available',
        'driver_cost_per_day',
        'available_for_sale',
        'sale_price',
        'condition',
        'is_sold',
        'status',
        'last_maintenance_at',
        'maintenance_notes',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'available_for_rent' => 'boolean',
            'self_drive_available' => 'boolean',
            'with_driver_available' => 'boolean',
            'available_for_sale' => 'boolean',
            'is_sold' => 'boolean',
            'rental_price_per_day' => 'decimal:2',
            'driver_cost_per_day' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'last_maintenance_at' => 'datetime',
        ];
    }

    // Relationships
    public function images(): HasMany
    {
        return $this->hasMany(VehicleImage::class)->orderBy('sort_order');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    // Scopes
    public function scopeAvailableForRent(Builder $query): Builder
    {
        return $query->where('available_for_rent', true)
                    ->where('status', 'available');
    }

    public function scopeAvailableForSale(Builder $query): Builder
    {
        return $query->where('available_for_sale', true)
                    ->where('is_sold', false)
                    ->where('status', '!=', 'sold');
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function scopeByMake(Builder $query, string $make): Builder
    {
        return $query->where('make', 'like', "%{$make}%");
    }

    public function scopePriceRange(Builder $query, float $min, float $max, string $type = 'rental'): Builder
    {
        $column = $type === 'rental' ? 'rental_price_per_day' : 'sale_price';
        return $query->whereBetween($column, [$min, $max]);
    }

    // Helper methods
    public function getPrimaryImageAttribute(): ?string
    {
        $primaryImage = $this->images()->where('is_primary', true)->first();
        return $primaryImage ? $primaryImage->image_path : null;
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->year} {$this->make} {$this->model}";
    }

    public function isAvailableForRent(): bool
    {
        return $this->available_for_rent && $this->status === 'available';
    }

    public function isAvailableForSale(): bool
    {
        return $this->available_for_sale && !$this->is_sold && $this->status !== 'sold';
    }

    public function isAvailableForDates(string $startDate, string $endDate): bool
    {
        return !$this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('pickup_date', [$startDate, $endDate])
                      ->orWhereBetween('return_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('pickup_date', '<=', $startDate)
                            ->where('return_date', '>=', $endDate);
                      });
            })->exists();
    }
}