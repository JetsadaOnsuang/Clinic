<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_card' => fake()->unique()->numerify('#############'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'dob' => fake()->dateTimeBetween('-80 years', '-1 year')->format('Y-m-d'),
            'gender' => fake()->randomElement(['Male', 'Female', 'Other']),
            'phone' => fake()->numerify('08########'),
            'address' => fake()->address(),
            'blood_group' => fake()->randomElement(['A', 'B', 'AB', 'O']),
            'allergies' => fake()->optional()->sentence(),
        ];
    }
}
