<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $term = trim(mb_substr((string) $request->query('q', ''), 0, 100));
        $like = "%{$term}%";
        $user = $request->user();
        $patients = Patient::query()
            ->when($user->isDoctor(), fn ($query) => $query->whereHas('appointments', fn ($appointments) => $appointments->where('doctor_id', $user->doctor_id)));
        $doctors = Doctor::query()
            ->when($user->isDoctor(), fn ($query) => $query->whereKey($user->doctor_id));
        $appointments = Appointment::query()
            ->when($user->isDoctor(), fn ($query) => $query->where('doctor_id', $user->doctor_id));

        return view('search.index', [
            'term' => $term,
            'patients' => $term === '' ? collect() : $patients
                ->where(fn ($query) => $query
                    ->where('first_name', 'like', $like)
                    ->orWhere('last_name', 'like', $like)
                    ->orWhere('id_card', 'like', $like)
                    ->orWhere('phone', 'like', $like))
                ->orderBy('first_name')
                ->limit(8)
                ->get(),
            'doctors' => $term === '' ? collect() : $doctors
                ->where(fn ($query) => $query
                    ->where('first_name', 'like', $like)
                    ->orWhere('last_name', 'like', $like)
                    ->orWhere('license_no', 'like', $like)
                    ->orWhere('specialty', 'like', $like))
                ->orderBy('first_name')
                ->limit(8)
                ->get(),
            'appointments' => $term === '' ? collect() : $appointments->with(['patient', 'doctor'])
                ->where(fn ($query) => $query
                    ->where('id', $term)
                    ->orWhere('symptoms', 'like', $like)
                    ->orWhere('diagnosis', 'like', $like)
                    ->orWhereHas('patient', fn ($patient) => $patient
                        ->where('first_name', 'like', $like)
                        ->orWhere('last_name', 'like', $like)
                        ->orWhere('id_card', 'like', $like))
                    ->orWhereHas('doctor', fn ($doctor) => $doctor
                        ->where('first_name', 'like', $like)
                        ->orWhere('last_name', 'like', $like)
                        ->orWhere('specialty', 'like', $like)))
                ->latest('appointment_date')
                ->limit(8)
                ->get(),
        ]);
    }
}
