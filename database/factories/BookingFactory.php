<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pickupDate = $this->faker->dateTimeBetween('now', '+30 days');
        $returnDate = $this->faker->dateTimeBetween($pickupDate, $pickupDate->format('Y-m-d') . ' +14 days');
        $totalDays = $pickupDate->diff($returnDate)->days + 1;
        $dailyRate = $this->faker->randomFloat(2, 50, 500);
        $driverCost = $this->faker->randomFloat(2, 30, 100);
        $drivingOption = $this->faker->randomElement(['self_drive', 'with_driver']);
        
        $subtotal = $dailyRate * $totalDays;
        if ($drivingOption === 'with_driver') {
            $subtotal += $driverCost * $totalDays;
        }
        
        $taxAmount = $subtotal * 0.15; // 15% tax
        $totalAmount = $subtotal + $taxAmount;

        return [
            'user_id' => User::factory(),
            'vehicle_id' => Vehicle::factory(),
            'pickup_date' => $pickupDate,
            'return_date' => $returnDate,
            'total_days' => $totalDays,
            'driving_option' => $drivingOption,
            'pickup_location' => $this->faker->address(),
            'pickup_latitude' => $this->faker->latitude(),
            'pickup_longitude' => $this->faker->longitude(),
            'return_location' => $this->faker->address(),
            'return_latitude' => $this->faker->latitude(),
            'return_longitude' => $this->faker->longitude(),
            'daily_rate' => $dailyRate,
            'driver_cost' => $driverCost,
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'status' => $this->faker->randomElement(['pending_payment', 'paid', 'confirmed', 'active', 'completed', 'cancelled']),
            'cancellation_reason' => $this->faker->optional()->sentence(),
            'cancelled_at' => $this->faker->optional()->dateTime(),
            'special_requests' => $this->faker->optional()->paragraph(),
            'payment_reminder_sent_at' => null,
            'payment_reminder_count' => 0,
            'auto_cancel_warning_sent_at' => null,
        ];
    }

    /**
     * Indicate that the booking is pending payment.
     */
    public function pendingPayment(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending_payment',
            'cancelled_at' => null,
            'cancellation_reason' => null,
        ]);
    }

    /**
     * Indicate that the booking is stuck (pending payment with no payment record).
     */
    public function stuck(): static
    {
        return $this->pendingPayment();
    }

    /**
     * Indicate that the booking is old (created hours ago).
     */
    public function createdHoursAgo(int $hours): static
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => now()->subHours($hours),
            'updated_at' => now()->subHours($hours),
        ]);
    }
}