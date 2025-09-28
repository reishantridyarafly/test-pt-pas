<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $today = now()->format('dmY');

        do {
            $newUserId = $today . str_pad($this->faker->numberBetween(1, 999), 3, '0', STR_PAD_LEFT);
        } while (Customer::where('user_id', $newUserId)->exists());

        return [
            'user_id' => $newUserId,
            'name'    => $this->faker->name(),
            'email'   => $this->faker->unique()->safeEmail(),
            'phone'   => $this->faker->unique()->phoneNumber(),
            'status'  => $this->faker->randomElement(['NEW CUSTOMER', 'LOYAL CUSTOMER']),
        ];
    }
}
