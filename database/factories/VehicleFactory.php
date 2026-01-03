<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'make' => $this->faker->randomElement(['Toyota', 'Honda', 'Ford', 'BMW', 'Mercedes']),
            'model' => $this->faker->randomElement(['Camry', 'Civic', 'Focus', 'X3', 'C-Class']),
            'year' => $this->faker->numberBetween(2015, 2024),
            'color' => $this->faker->colorName(),
            'license_plate' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{4}'),
            'mileage' => $this->faker->numberBetween(0, 200000),
            'fuel_type' => $this->faker->randomElement(['petrol', 'diesel', 'hybrid', 'electric']),
            'transmission' => $this->faker->randomElement(['manual', 'automatic']),
            'category' => $this->faker->randomElement(['sedan', 'suv', 'pickup', 'luxury', 'compact', 'van']),
            'description' => $this->faker->paragraph(),
            'features' => $this->faker->randomElements(['AC', 'GPS', 'Bluetooth', 'Backup Camera', 'Sunroof'], 3),
            'available_for_rent' => $this->faker->boolean(80),
            'rental_price_per_day' => $this->faker->randomFloat(2, 50, 500),
            'self_drive_available' => $this->faker->boolean(90),
            'with_driver_available' => $this->faker->boolean(70),
            'driver_cost_per_day' => $this->faker->randomFloat(2, 30, 100),
            'available_for_sale' => $this->faker->boolean(30),
            'sale_price' => $this->faker->randomFloat(2, 10000, 100000),
            'condition' => $this->faker->randomElement(['excellent', 'good', 'fair']),
            'is_sold' => false,
            'status' => $this->faker->randomElement(['available', 'maintenance', 'reserved']),
            'last_maintenance_at' => $this->faker->optional()->dateTimeBetween('-6 months', 'now'),
            'maintenance_notes' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the vehicle is available for rent.
     */
    public function availableForRent(): static
    {
        return $this->state(fn (array $attributes) => [
            'available_for_rent' => true,
            'status' => 'available',
        ]);
    }

    /**
     * Indicate that the vehicle is available for sale.
     */
    public function availableForSale(): static
    {
        return $this->state(fn (array $attributes) => [
            'available_for_sale' => true,
            'is_sold' => false,
        ]);
    }
}