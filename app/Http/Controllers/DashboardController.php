<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        /** @var User $user */
        $user = request()->user();
        $appointments = Appointment::query()
            ->when($user->isDoctor(), fn ($query) => $query->where('doctor_id', $user->doctor_id));
        $firstMonth = today()->startOfMonth()->subMonths(5);
        $monthlyAppointments = collect(range(0, 5))->map(function (int $offset) use ($firstMonth): array {
            $month = $firstMonth->copy()->addMonths($offset);

            return [
                'label' => $month->translatedFormat('M'),
                'count' => Appointment::query()
                    ->when(request()->user()->isDoctor(), fn ($query) => $query->where('doctor_id', request()->user()->doctor_id))
                    ->whereYear('appointment_date', $month->year)
                    ->whereMonth('appointment_date', $month->month)
                    ->count(),
            ];
        });
        $maxMonthlyAppointments = max(1, (int) $monthlyAppointments->max('count'));

        return view('dashboard', [
            'isAdmin' => $user->isAdmin(),
            'patientCount' => $user->isAdmin()
                ? Patient::count()
                : Patient::whereHas('appointments', fn ($query) => $query->where('doctor_id', $user->doctor_id))
                    ->distinct()
                    ->count('patients.id'),
            'doctorCount' => $user->isAdmin() ? Doctor::count() : 1,
            'todayCount' => (clone $appointments)->whereDate('appointment_date', today())->count(),
            'todayDoctorCount' => (clone $appointments)->whereDate('appointment_date', today())
                ->where('status', '!=', 'Cancelled')
                ->distinct('doctor_id')
                ->count('doctor_id'),
            'monthlyAppointments' => $monthlyAppointments,
            'maxMonthlyAppointments' => $maxMonthlyAppointments,
            'recentAppointments' => $appointments->with(['patient', 'doctor'])
                ->latest()
                ->limit(8)
                ->get(),
        ]);
    }
}
