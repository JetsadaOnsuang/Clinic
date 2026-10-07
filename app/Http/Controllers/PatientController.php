<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $patients = Patient::query()
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('id_card', 'like', "%{$search}%");
            }))
            ->orderBy('first_name')
            ->paginate(12)
            ->withQueryString();

        return view('patients.index', compact('patients', 'search'));
    }

    public function create(): View
    {
        return view('patients.form', ['patient' => new Patient()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Patient::create($this->validated($request));

        return redirect()->route('patients.index')->with('success', 'เพิ่มข้อมูลผู้ป่วยแล้ว');
    }

    public function edit(Patient $patient): View
    {
        return view('patients.form', compact('patient'));
    }

    public function update(Request $request, Patient $patient): RedirectResponse
    {
        $patient->update($this->validated($request, $patient));

        return redirect()->route('patients.index')->with('success', 'บันทึกการแก้ไขแล้ว');
    }

    public function destroy(Patient $patient): RedirectResponse
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'ลบข้อมูลผู้ป่วยและนัดหมายที่เกี่ยวข้องแล้ว');
    }

    private function validated(Request $request, ?Patient $patient = null): array
    {
        return $request->validate([
            'id_card' => ['required', 'digits:13', Rule::unique('patients', 'id_card')->ignore($patient)],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'dob' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'phone' => ['required', 'string', 'max:15'],
            'address' => ['nullable', 'string'],
            'blood_group' => ['nullable', Rule::in(['A', 'B', 'AB', 'O'])],
            'allergies' => ['nullable', 'string'],
        ]);
    }
}
