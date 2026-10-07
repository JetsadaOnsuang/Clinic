<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'license_no' => fake()->unique()->numerify('MED-########'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'specialty' => fake()->randomElement(['เวชปฏิบัติทั่วไป', 'กุมารเวชกรรม', 'ผิวหนัง', 'ทันตกรรม']),
            'phone' => fake()->numerify('08########'),
            'email' => fake()->unique()->numerify('doctor####').'@clinic.test',
        ];
    }
}
