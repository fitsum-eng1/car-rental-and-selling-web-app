<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;

class StuckBookingDetector
{
    /**
     * Get all bookings that are stuck in pending payment status without payment records
     */
    public function getStuckBookings(): Collection
    {
        return Booking::stuck()
            ->with(['user', 'vehicle'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Check if a specific booking is stuck
     */
    public function isStuckBooking(Booking $booking): bool
    {
        return $booking->isStuck();
    }

    /**
     * Get the age of a stuck booking in hours
     */
    public function getStuckBookingAge(Booking $booking): int
    {
        return $booking->getStuckAge();
    }

    /**
     * Get the urgency level of a stuck booking
     */
    public function getUrgencyLevel(Booking $booking): string
    {
        return $booking->getUrgencyLevel();
    }

    /**
     * Get stuck bookings grouped by urgency level
     */
    public function getStuckBookingsByUrgency(): array
    {
        $stuckBookings = $this->getStuckBookings();
        
        return [
            'critical' => $stuckBookings->filter(fn($booking) => $this->getUrgencyLevel($booking) === 'critical'),
            'urgent' => $stuckBookings->filter(fn($booking) => $this->getUrgencyLevel($booking) === 'urgent'),
            'warning' => $stuckBookings->filter(fn($booking) => $this->getUrgencyLevel($booking) === 'warning'),
            'normal' => $stuckBookings->filter(fn($booking) => $this->getUrgencyLevel($booking) === 'normal'),
        ];
    }

    /**
     * Get count of stuck bookings
     */
    public function getStuckBookingsCount(): int
    {
        return Booking::stuck()->count();
    }

    /**
     * Get the oldest stuck booking
     */
    public function getOldestStuckBooking(): ?Booking
    {
        return Booking::stuck()
            ->orderBy('created_at', 'asc')
            ->first();
    }

    /**
     * Get stuck bookings that need immediate attention (over 48 hours)
     */
    public function getUrgentStuckBookings(): Collection
    {
        return Booking::stuckOlderThan(48)
            ->with(['user', 'vehicle'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Get stuck bookings that are critical (over 7 days)
     */
    public function getCriticalStuckBookings(): Collection
    {
        return Booking::critical()
            ->with(['user', 'vehicle'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Get dashboard statistics for stuck bookings
     */
    public function getDashboardStats(): array
    {
        $stuckBookings = $this->getStuckBookings();
        $oldestBooking = $this->getOldestStuckBooking();
        
        return [
            'total_stuck' => $stuckBookings->count(),
            'critical_count' => $stuckBookings->filter(fn($booking) => $this->getUrgencyLevel($booking) === 'critical')->count(),
            'urgent_count' => $stuckBookings->filter(fn($booking) => $this->getUrgencyLevel($booking) === 'urgent')->count(),
            'warning_count' => $stuckBookings->filter(fn($booking) => $this->getUrgencyLevel($booking) === 'warning')->count(),
            'normal_count' => $stuckBookings->filter(fn($booking) => $this->getUrgencyLevel($booking) === 'normal')->count(),
            'oldest_age_hours' => $oldestBooking ? $this->getStuckBookingAge($oldestBooking) : 0,
            'oldest_age_days' => $oldestBooking ? round($this->getStuckBookingAge($oldestBooking) / 24, 1) : 0,
        ];
    }
}