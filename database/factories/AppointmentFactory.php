<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Support\ClinicDemoSymptoms;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        $exampleIndex = fake()->numberBetween(0, count(ClinicDemoSymptoms::all()) - 1);
        $status = fake()->randomElement(['Pending', 'Completed', 'Cancelled']);

        return [
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'appointment_date' => fake()->dateTimeBetween('-30 days', '+30 days'),
            'symptoms' => ClinicDemoSymptoms::forIndex($exampleIndex),
            'diagnosis' => $status === 'Completed' ? ClinicDemoSymptoms::diagnosisForIndex($exampleIndex) : null,
            'status' => $status,
        ];
    }
}
