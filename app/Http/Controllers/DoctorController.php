<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $doctors = Doctor::with('user')
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('specialty', 'like', "%{$search}%")
                    ->orWhere('license_no', 'like', "%{$search}%");
            }))
            ->orderBy('first_name')
            ->paginate(12)
            ->withQueryString();

        return view('doctors.index', compact('doctors', 'search'));
    }

    public function create(): View
    {
        return view('doctors.form', ['doctor' => new Doctor, 'account' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            $data = $this->validated($request);
            $account = $this->accountData($data);
            $doctor = Doctor::create($data);

            if ($account !== null) {
                $doctor->user()->create($account);
            }
        });

        return redirect()->route('doctors.index')->with('success', 'เพิ่มข้อมูลแพทย์และบัญชีเข้าสู่ระบบแล้ว');
    }

    public function edit(Doctor $doctor): View
    {
        return view('doctors.form', ['doctor' => $doctor, 'account' => $doctor->user]);
    }

    public function update(Request $request, Doctor $doctor): RedirectResponse
    {
        DB::transaction(function () use ($request, $doctor): void {
            $data = $this->validated($request, $doctor);
            $account = $this->accountData($data);
            $doctor->update($data);

            if ($account !== null) {
                $doctor->user()->updateOrCreate([], $account);
            }
        });

        return redirect()->route('doctors.index')->with('success', 'บันทึกข้อมูลแพทย์แล้ว');
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'ลบข้อมูลแพทย์และนัดหมายที่เกี่ยวข้องแล้ว');
    }

    private function validated(Request $request, ?Doctor $doctor = null): array
    {
        $hasAccount = $doctor?->user()->exists() ?? false;

        return $request->validate([
            'license_no' => ['required', 'string', 'max:20', Rule::unique('doctors', 'license_no')->ignore($doctor)],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'specialty' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:15'],
            'email' => ['nullable', 'email', 'max:100'],
            'account_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($doctor?->user?->id),
            ],
            'account_password' => [$hasAccount ? 'nullable' : 'required', 'string', 'min:8'],
        ]);
    }

    private function accountData(array &$data): ?array
    {
        $email = $data['account_email'] ?? null;
        $password = $data['account_password'] ?? null;
        unset($data['account_email'], $data['account_password']);

        if ($email === null || $email === '') {
            return null;
        }

        $account = [
            'name' => trim($data['first_name'].' '.$data['last_name']),
            'email' => $email,
            'role' => 'doctor',
            'is_admin' => false,
        ];

        if ($password !== null && $password !== '') {
            $account['password'] = $password;
        }

        return $account;
    }
}
