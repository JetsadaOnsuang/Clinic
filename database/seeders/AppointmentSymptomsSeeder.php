<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Support\ClinicDemoSymptoms;
use Illuminate\Database\Seeder;

class AppointmentSymptomsSeeder extends Seeder
{
    public function run(): void
    {
        Appointment::query()
            ->orderBy('id')
            ->get()
            ->each(function (Appointment $appointment, int $index): void {
                $appointment->update([
                    'symptoms' => ClinicDemoSymptoms::forIndex($index),
                    'diagnosis' => $appointment->status === 'Completed'
                        ? ClinicDemoSymptoms::diagnosisForIndex($index)
                        : null,
                ]);
            });
    }
}
