<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicAppointmentStatusController extends Controller
{
    public function create(): View
    {
        return view('appointments.public-status');
    }

    public function store(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'id_card' => ['required', 'digits:13'],
            'phone' => ['required', 'string', 'max:15'],
        ], [
            'id_card.required' => 'กรุณากรอกเลขบัตรประชาชน',
            'id_card.digits' => 'เลขบัตรประชาชนต้องมี 13 หลัก',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์ที่ลงทะเบียน',
            'phone.max' => 'เบอร์โทรศัพท์ต้องไม่เกิน 15 ตัวอักษร',
        ]);

        $patient = Patient::query()
            ->where('id_card', $validated['id_card'])
            ->where('phone', $validated['phone'])
            ->first();

        if ($patient === null) {
            return back()
                ->withInput()
                ->withErrors(['lookup' => 'ไม่พบข้อมูล กรุณาตรวจสอบเลขบัตรประชาชนและเบอร์โทรศัพท์ที่ลงทะเบียน']);
        }

        $appointments = $patient->appointments()
            ->with('doctor:id,first_name,last_name,specialty')
            ->orderByDesc('appointment_date')
            ->get(['id', 'doctor_id', 'appointment_date', 'status']);

        return view('appointments.public-status', [
            'patient' => $patient,
            'appointments' => $appointments,
        ]);
    }
}
