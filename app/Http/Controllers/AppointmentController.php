<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function show(Appointment $appointment): View
    {
        $this->authorizeAppointment($appointment);

        return view('appointments.show', compact('appointment'));
    }

    public function index(Request $request): View
    {
        $term = trim(mb_substr((string) $request->query('q', ''), 0, 100));

        $appointments = Appointment::with(['patient', 'doctor'])
            ->when($request->user()->isDoctor(), fn ($query) => $query->where('doctor_id', $request->user()->doctor_id))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->query('status')))
            ->when($term !== '', fn ($query) => $query->where(function ($query) use ($term) {
                $like = "%{$term}%";

                $query->where('symptoms', 'like', $like)
                    ->orWhere('diagnosis', 'like', $like)
                    ->orWhereHas('patient', fn ($patient) => $patient
                        ->where('first_name', 'like', $like)
                        ->orWhere('last_name', 'like', $like)
                        ->orWhere('id_card', 'like', $like))
                    ->orWhereHas('doctor', fn ($doctor) => $doctor
                        ->where('first_name', 'like', $like)
                        ->orWhere('last_name', 'like', $like));
            }))
            ->orderByDesc('appointment_date')
            ->paginate(12)
            ->withQueryString();

        return view('appointments.index', compact('appointments', 'term'));
    }

    public function create(Request $request): View
    {
        return view('appointments.form', [
            'appointment' => new Appointment([
                'status' => 'Pending',
                'appointment_date' => now()->addHour()->startOfHour(),
                'patient_id' => $request->integer('patient_id') ?: null,
                'doctor_id' => $request->integer('doctor_id') ?: null,
            ]),
            'patients' => Patient::orderBy('first_name')->get(),
            'doctors' => Doctor::orderBy('first_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Appointment::create($this->validated($request));

        return redirect()->route('appointments.index')->with('success', 'เพิ่มนัดหมายแล้ว');
    }

    public function edit(Appointment $appointment): View
    {
        $this->authorizeAppointment($appointment);

        return view('appointments.form', [
            'appointment' => $appointment,
            'patients' => auth()->user()->isAdmin()
                ? Patient::orderBy('first_name')->get()
                : collect([$appointment->patient]),
            'doctors' => auth()->user()->isAdmin()
                ? Doctor::orderBy('first_name')->get()
                : collect([$appointment->doctor]),
        ]);
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $this->authorizeAppointment($appointment);

        if ($request->user()->isDoctor()) {
            $appointment->update($request->validate([
                'symptoms' => ['required', 'string'],
                'diagnosis' => ['nullable', 'string'],
                'status' => ['required', Rule::in(['Pending', 'Completed'])],
            ]));

            return redirect()->route('appointments.show', $appointment)->with('success', 'บันทึกข้อมูลการตรวจแล้ว');
        }

        $appointment->update($this->validated($request));

        return redirect()->route('appointments.index')->with('success', 'บันทึกการแก้ไขแล้ว');
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'ลบนัดหมายแล้ว');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date'],
            'symptoms' => ['required', 'string'],
            'diagnosis' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['Pending', 'Completed', 'Cancelled'])],
        ]);
    }

    private function authorizeAppointment(Appointment $appointment): void
    {
        $user = auth()->user();
        abort_unless($user->isAdmin() || ($user->isDoctor() && $appointment->doctor_id === $user->doctor_id), 404);
    }
}
