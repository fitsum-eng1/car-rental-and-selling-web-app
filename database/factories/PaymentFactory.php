<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null, // Will be set explicitly in tests
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'payment_method' => $this->faker->randomElement(['bank_transfer', 'mobile_money', 'cash']),
            'bank_name' => $this->faker->randomElement(['Commercial Bank of Ethiopia', 'Dashen Bank', 'Bank of Abyssinia', 'Awash Bank']),
            'account_number' => $this->faker->numerify('##########'),
            'payment_instructions' => $this->faker->paragraph(),
            'transaction_reference' => $this->faker->optional()->numerify('TXN##########'),
            'transaction_proof' => $this->faker->optional()->imageUrl(),
            'transaction_date' => $this->faker->optional()->dateTimeBetween('-7 days', 'now'),
            'status' => $this->faker->randomElement(['pending', 'submitted', 'verified', 'rejected']),
            'rejection_reason' => $this->faker->optional()->sentence(),
            'verified_by' => $this->faker->optional()->randomNumber(),
            'verified_at' => $this->faker->optional()->dateTimeBetween('-7 days', 'now'),
            'expires_at' => $this->faker->dateTimeBetween('now', '+24 hours'),
        ];
    }

    /**
     * Indicate that the payment is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => User::factory(),
        ]);
    }

    /**
     * Indicate that the payment is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'verified_at' => null,
            'verified_by' => null,
        ]);
    }
}