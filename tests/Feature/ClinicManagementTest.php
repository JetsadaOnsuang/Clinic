<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Support\ClinicDemoSymptoms;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClinicManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get('/')->assertRedirect(route('dashboard'));
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_patient_can_check_all_appointment_statuses_without_signing_in(): void
    {
        $patient = Patient::factory()->create([
            'id_card' => '1234567890123',
            'phone' => '0812345678',
        ]);
        $olderAppointment = Appointment::factory()->create([
            'patient_id' => $patient->id,
            'appointment_date' => now()->subMonth(),
            'status' => 'Completed',
            'symptoms' => 'ข้อมูลอาการที่เป็นความลับ',
            'diagnosis' => 'ข้อมูลวินิจฉัยที่เป็นความลับ',
        ]);
        $newerAppointment = Appointment::factory()->create([
            'patient_id' => $patient->id,
            'appointment_date' => now()->addMonth(),
            'status' => 'Pending',
        ]);
        $otherPatientAppointment = Appointment::factory()->create();

        $this->get(route('login'))
            ->assertOk()
            ->assertSee(route('appointment-status.create'));
        $this->get(route('appointment-status.create'))->assertOk();
        $this->post(route('appointment-status.lookup'), [
            'id_card' => $patient->id_card,
            'phone' => $patient->phone,
        ])
            ->assertOk()
            ->assertSee('นัดหมายของ '.$patient->first_name.' '.$patient->last_name)
            ->assertSee('ตรวจแล้ว')
            ->assertSee('รอตรวจ')
            ->assertSee('นพ. '.$olderAppointment->doctor->first_name.' '.$olderAppointment->doctor->last_name)
            ->assertDontSee('ข้อมูลอาการที่เป็นความลับ')
            ->assertDontSee('ข้อมูลวินิจฉัยที่เป็นความลับ')
            ->assertDontSee($otherPatientAppointment->patient->first_name);
    }

    public function test_patient_appointment_lookup_requires_both_registered_identifiers(): void
    {
        $patient = Patient::factory()->create([
            'id_card' => '1234567890123',
            'phone' => '0812345678',
        ]);
        Appointment::factory()->create(['patient_id' => $patient->id]);

        $this->post(route('appointment-status.lookup'), [
            'id_card' => $patient->id_card,
            'phone' => '0899999999',
        ])
            ->assertRedirect()
            ->assertSessionHasErrors('lookup');
    }

    public function test_admin_can_sign_in_and_view_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('ภาพรวมคลินิก')
            ->assertSee('สถิติการนัดหมาย 6 เดือนล่าสุด');
    }

    public function test_non_admin_cannot_sign_in(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');
    }

    public function test_doctor_can_sign_in_and_only_see_assigned_patients_and_appointments(): void
    {
        $doctor = Doctor::factory()->create();
        $account = User::factory()->create([
            'name' => $doctor->first_name.' '.$doctor->last_name,
            'email' => 'doctor.login@clinic.test',
            'is_admin' => false,
            'role' => 'doctor',
            'doctor_id' => $doctor->id,
        ]);
        $ownAppointment = Appointment::factory()->create(['doctor_id' => $doctor->id]);
        $otherAppointment = Appointment::factory()->create();

        $this->post(route('login.store'), [
            'email' => $account->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->get(route('dashboard'))->assertOk()->assertSee($ownAppointment->patient->first_name);
        $this->get(route('appointments.index'))
            ->assertOk()
            ->assertSee(route('appointments.show', $ownAppointment))
            ->assertDontSee(route('appointments.show', $otherAppointment));
        $this->get(route('search', ['q' => $otherAppointment->patient->id_card]))
            ->assertOk()
            ->assertSee('ไม่พบผู้ป่วยที่ตรงกับคำค้น')
            ->assertDontSee(route('appointments.show', $otherAppointment));
        $this->get(route('patients.index'))->assertForbidden();
        $this->get(route('doctors.index'))->assertForbidden();
        $this->get(route('appointments.create'))->assertForbidden();
        $this->delete(route('appointments.destroy', $ownAppointment))->assertForbidden();
    }

    public function test_doctor_can_update_clinical_notes_only_for_their_own_appointment(): void
    {
        $doctor = Doctor::factory()->create();
        $this->actingAs(User::factory()->create([
            'is_admin' => false,
            'role' => 'doctor',
            'doctor_id' => $doctor->id,
        ]));
        $ownAppointment = Appointment::factory()->create(['doctor_id' => $doctor->id]);
        $otherAppointment = Appointment::factory()->create();

        $this->put(route('appointments.update', $ownAppointment), [
            'symptoms' => 'บันทึกอาการโดยแพทย์',
            'diagnosis' => 'วินิจฉัยแล้ว',
            'status' => 'Completed',
            'patient_id' => $otherAppointment->patient_id,
            'doctor_id' => $otherAppointment->doctor_id,
            'appointment_date' => now()->addYear()->format('Y-m-d\TH:i'),
        ])->assertRedirect(route('appointments.show', $ownAppointment));

        $this->assertDatabaseHas('appointments', [
            'id' => $ownAppointment->id,
            'doctor_id' => $doctor->id,
            'patient_id' => $ownAppointment->patient_id,
            'symptoms' => 'บันทึกอาการโดยแพทย์',
            'diagnosis' => 'วินิจฉัยแล้ว',
            'status' => 'Completed',
        ]);
        $this->put(route('appointments.update', $otherAppointment), [
            'symptoms' => 'ไม่ควรบันทึกได้',
            'status' => 'Completed',
        ])->assertNotFound();
    }

    public function test_admin_can_open_all_management_pages(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        foreach ([
            'patients.index',
            'patients.create',
            'doctors.index',
            'doctors.create',
            'appointments.index',
            'appointments.create',
        ] as $route) {
            $this->get(route($route))->assertOk();
        }
    }

    public function test_admin_can_search_patients_doctors_and_appointments_from_one_page(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $patient = Patient::factory()->create([
            'first_name' => 'คลินิก',
            'last_name' => 'ทดสอบ',
            'id_card' => '1111111111111',
        ]);
        $doctor = Doctor::factory()->create([
            'first_name' => 'แพทย์ค้นหา',
            'last_name' => 'ทดสอบ',
        ]);
        $appointment = Appointment::factory()->create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'symptoms' => 'อาการค้นหาเฉพาะ',
        ]);

        $this->get(route('search', ['q' => 'คลินิก']))
            ->assertOk()
            ->assertSee('คลินิก')
            ->assertSee('นัดหมาย');

        $this->get(route('search', ['q' => 'อาการค้นหาเฉพาะ']))
            ->assertOk()
            ->assertSee('อาการค้นหาเฉพาะ')
            ->assertSee(route('appointments.show', $appointment));
    }

    public function test_appointment_list_can_search_and_clear_status_filters(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $appointment = Appointment::factory()->create([
            'symptoms' => 'อาการสำหรับค้นหา',
            'status' => 'Completed',
        ]);

        $this->get(route('appointments.index', ['q' => 'อาการสำหรับค้นหา', 'status' => 'Completed']))
            ->assertOk()
            ->assertSee('อาการสำหรับค้นหา')
            ->assertSee(route('appointments.show', $appointment))
            ->assertSee(route('appointments.index'));

        $this->get(route('appointments.index', ['q' => 'อาการไม่พบ', 'status' => 'Pending']))
            ->assertOk()
            ->assertSee('ล้างตัวกรอง');
    }

    public function test_admin_can_create_and_update_patient_and_doctor(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $this->post(route('patients.store'), [
            'id_card' => '1234567890123',
            'first_name' => 'สมชาย',
            'last_name' => 'ใจดี',
            'dob' => '1990-01-01',
            'gender' => 'Male',
            'phone' => '0812345678',
        ])->assertRedirect(route('patients.index'));

        $patient = Patient::firstOrFail();
        $this->put(route('patients.update', $patient), [
            'id_card' => $patient->id_card,
            'first_name' => 'สมชาย',
            'last_name' => 'แก้ไขแล้ว',
            'dob' => '1990-01-01',
            'gender' => 'Male',
            'phone' => '0812345678',
        ])->assertRedirect(route('patients.index'));
        $this->assertDatabaseHas('patients', ['id' => $patient->id, 'last_name' => 'แก้ไขแล้ว']);

        $this->post(route('doctors.store'), [
            'license_no' => 'DOC-10001',
            'first_name' => 'แพทย์',
            'last_name' => 'ตัวอย่าง',
            'specialty' => 'เวชปฏิบัติทั่วไป',
            'phone' => '0899999999',
            'email' => 'doctor@clinic.test',
            'account_email' => 'doctor.account@clinic.test',
            'account_password' => 'doctorpass123',
        ])->assertRedirect(route('doctors.index'));

        $doctor = Doctor::firstOrFail();
        $this->assertDatabaseHas('users', [
            'email' => 'doctor.account@clinic.test',
            'role' => 'doctor',
            'doctor_id' => $doctor->id,
        ]);
        $this->put(route('doctors.update', $doctor), [
            'license_no' => $doctor->license_no,
            'first_name' => 'แพทย์',
            'last_name' => 'แก้ไขแล้ว',
            'specialty' => 'เวชปฏิบัติทั่วไป',
            'phone' => '0899999999',
            'email' => 'doctor@clinic.test',
            'account_email' => 'doctor.account@clinic.test',
        ])->assertRedirect(route('doctors.index'));
        $this->assertDatabaseHas('doctors', ['id' => $doctor->id, 'last_name' => 'แก้ไขแล้ว']);
    }

    public function test_admin_can_create_patient_doctor_and_appointment(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $patient = Patient::factory()->create();
        $doctor = Doctor::factory()->create();

        $this->post(route('appointments.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => now()->addDay()->format('Y-m-d H:i:s'),
            'symptoms' => 'ปวดศีรษะ',
            'status' => 'Pending',
        ])->assertRedirect(route('appointments.index'));

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'symptoms' => 'ปวดศีรษะ',
        ]);
        $this->assertInstanceOf(Patient::class, Appointment::firstOrFail()->patient);
        $this->assertInstanceOf(Doctor::class, Appointment::firstOrFail()->doctor);
        $this->get(route('appointments.show', Appointment::firstOrFail()))
            ->assertOk()
            ->assertSee('ปวดศีรษะ')
            ->assertSee('รายละเอียดนัดหมาย');
    }

    public function test_deleting_patient_cascades_to_appointments(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $appointment = Appointment::factory()->create();

        $this->delete(route('patients.destroy', $appointment->patient))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('patients', ['id' => $appointment->patient_id]);
        $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
    }

    public function test_deleting_doctor_cascades_to_appointments(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $appointment = Appointment::factory()->create();

        $this->delete(route('doctors.destroy', $appointment->doctor))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('doctors', ['id' => $appointment->doctor_id]);
        $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
    }

    public function test_sample_appointments_are_varied_and_balanced_across_six_months(): void
    {
        $this->seed();

        $this->assertDatabaseHas('users', ['email' => 'admin@clinic.co.th', 'role' => 'admin']);
        foreach (range(1, 10) as $doctorId) {
            $this->assertDatabaseHas('users', [
                'email' => "doctor{$doctorId}@clinic.co.th",
                'doctor_id' => $doctorId,
            ]);
        }

        $firstMonth = Carbon::today()->startOfMonth()->subMonths(5);
        $expectedCounts = [12, 16, 18, 21, 24, 29];
        $actualCounts = [];

        foreach ($expectedCounts as $offset => $expectedCount) {
            $month = $firstMonth->copy()->addMonths($offset);
            $actualCount = Appointment::whereYear('appointment_date', $month->year)
                ->whereMonth('appointment_date', $month->month)
                ->count();

            $this->assertSame($expectedCount, $actualCount);
            $actualCounts[] = $actualCount;
        }

        $this->assertSame(120, array_sum($actualCounts));
        $this->assertCount(6, array_unique($actualCounts));
    }

    public function test_appointment_symptoms_seeder_replaces_gibberish_without_changing_other_data(): void
    {
        $appointment = Appointment::factory()->create([
            'symptoms' => 'Random words without medical context.',
            'diagnosis' => 'Existing diagnosis remains unchanged',
            'status' => 'Completed',
        ]);
        $appointmentDate = $appointment->appointment_date->toDateTimeString();

        $this->seed(\Database\Seeders\AppointmentSymptomsSeeder::class);

        $appointment->refresh();
        $this->assertContains($appointment->symptoms, ClinicDemoSymptoms::all());
        $this->assertNotSame('Random words without medical context.', $appointment->symptoms);
        $this->assertStringStartsWith('ประเมินเบื้องต้น:', $appointment->diagnosis);
        $this->assertStringNotContainsString('ข้อมูลสาธิต', $appointment->diagnosis);
        $this->assertSame($appointmentDate, $appointment->appointment_date->toDateTimeString());
    }
}
