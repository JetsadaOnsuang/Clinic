<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->where('is_admin', true)->first() ?? new User;
        $isNewAdmin = ! $admin->exists;

        $admin->fill([
            'name' => 'ผู้ดูแลระบบ',
            'email' => 'admin@clinic.co.th',
            'is_admin' => true,
            'role' => 'admin',
        ]);
        if ($isNewAdmin) {
            $admin->password = env('ADMIN_PASSWORD', 'password');
        }
        $admin->save();

        $patients = Patient::factory(100)->create();
        $doctors = Doctor::factory(10)->create();

        $this->call(DoctorAccountsSeeder::class);

        $firstMonth = today()->startOfMonth()->subMonths(5);
        $appointmentsPerMonth = [12, 16, 18, 21, 24, 29];
        $appointmentIndex = 0;

        foreach ($appointmentsPerMonth as $monthOffset => $monthlyCount) {
            $month = $firstMonth->copy()->addMonths($monthOffset);
            $daysToSpreadAcross = min($month->daysInMonth, 28);

            for ($monthIndex = 0; $monthIndex < $monthlyCount; $monthIndex++) {
                $dayOffset = (int) floor($monthIndex * ($daysToSpreadAcross - 1) / max(1, $monthlyCount - 1));

                Appointment::factory()->create([
                    'patient_id' => $patients->random()->id,
                    'doctor_id' => $doctors->random()->id,
                    'appointment_date' => $month->copy()
                        ->addDays($dayOffset)
                        ->setTime(9 + ($appointmentIndex % 8), ($appointmentIndex % 4) * 15),
                ]);

                $appointmentIndex++;
            }
        }

        $this->call(AppointmentSymptomsSeeder::class);
    }
}
