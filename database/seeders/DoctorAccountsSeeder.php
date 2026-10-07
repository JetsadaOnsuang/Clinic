<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorAccountsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Doctor::query()->orderBy('id')->get() as $doctor) {
            $account = User::firstOrNew(['doctor_id' => $doctor->id]);
            $isNewAccount = ! $account->exists;

            $account->fill([
                'name' => trim($doctor->first_name.' '.$doctor->last_name),
                'email' => "doctor{$doctor->id}@clinic.co.th",
                'is_admin' => false,
                'role' => 'doctor',
            ]);
            if ($isNewAccount) {
                $account->password = env('DOCTOR_PASSWORD', 'password');
            }
            $account->save();
        }
    }
}
