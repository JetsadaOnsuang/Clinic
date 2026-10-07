@extends('layouts.app')

@section('title', $appointment->exists ? 'แก้ไขนัดหมาย' : 'เพิ่มนัดหมาย')
@section('heading', $appointment->exists ? 'แก้ไขนัดหมาย' : 'เพิ่มนัดหมาย')
@section('subheading', 'เลือกผู้ป่วย แพทย์ และเวลานัดหมาย')

@section('content')
<section class="card p-3 p-md-4">
    @if (auth()->user()->isAdmin() && ($patients->isEmpty() || $doctors->isEmpty()))
        <div class="alert alert-warning mb-0">ต้องเพิ่มข้อมูลผู้ป่วยและแพทย์ก่อน จึงจะสร้างนัดหมายได้</div>
        <div class="d-flex gap-2 mt-3">
            @if ($patients->isEmpty())<a href="{{ route('patients.create') }}" class="btn btn-outline-primary">เพิ่มผู้ป่วย</a>@endif
            @if ($doctors->isEmpty())<a href="{{ route('doctors.create') }}" class="btn btn-outline-primary">เพิ่มแพทย์</a>@endif
        </div>
    @else
    <form method="POST" action="{{ $appointment->exists ? route('appointments.update', $appointment) : route('appointments.store') }}">
        @csrf
        @if ($appointment->exists) @method('PUT') @endif
        <div class="row g-3">
            @if (auth()->user()->isAdmin())
                <div class="col-md-6"><label class="form-label" for="patient_id">ผู้ป่วย</label><select id="patient_id" name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required><option value="">เลือกผู้ป่วย</option>@foreach ($patients as $patient)<option value="{{ $patient->id }}" @selected((string) old('patient_id', $appointment->patient_id) === (string) $patient->id)>{{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->id_card }})</option>@endforeach</select>@error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label" for="doctor_id">แพทย์</label><select id="doctor_id" name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required><option value="">เลือกแพทย์</option>@foreach ($doctors as $doctor)<option value="{{ $doctor->id }}" @selected((string) old('doctor_id', $appointment->doctor_id) === (string) $doctor->id)>นพ. {{ $doctor->first_name }} {{ $doctor->last_name }} — {{ $doctor->specialty }}</option>@endforeach</select>@error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label" for="appointment_date">วันและเวลานัดหมาย</label><input id="appointment_date" name="appointment_date" type="datetime-local" value="{{ old('appointment_date', $appointment->appointment_date?->format('Y-m-d\TH:i')) }}" class="form-control @error('appointment_date') is-invalid @enderror" required>@error('appointment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label" for="status">สถานะ</label><select id="status" name="status" class="form-select" required>@foreach (['Pending' => 'รอตรวจ', 'Completed' => 'ตรวจแล้ว', 'Cancelled' => 'ยกเลิก'] as $value => $label)<option value="{{ $value }}" @selected(old('status', $appointment->status) === $value)>{{ $label }}</option>@endforeach</select></div>
            @else
                <div class="col-md-6"><label class="form-label">ผู้ป่วย</label><div class="form-control bg-light">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }} · {{ $appointment->patient->id_card }}</div></div>
                <div class="col-md-6"><label class="form-label">วันและเวลา</label><div class="form-control bg-light">{{ $appointment->appointment_date->format('d/m/Y H:i') }}</div></div>
                <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                <input type="hidden" name="appointment_date" value="{{ $appointment->appointment_date->format('Y-m-d\TH:i') }}">
                <div class="col-md-6"><label class="form-label" for="status">สถานะการตรวจ</label><select id="status" name="status" class="form-select" required>@foreach (['Pending' => 'รอตรวจ', 'Completed' => 'ตรวจแล้ว'] as $value => $label)<option value="{{ $value }}" @selected(old('status', $appointment->status) === $value)>{{ $label }}</option>@endforeach</select></div>
            @endif
            <div class="col-12"><label class="form-label" for="symptoms">อาการเบื้องต้น / บันทึกการตรวจ</label><textarea id="symptoms" name="symptoms" rows="3" class="form-control @error('symptoms') is-invalid @enderror" required>{{ old('symptoms', $appointment->symptoms) }}</textarea>@error('symptoms')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-12"><label class="form-label" for="diagnosis">ผลการวินิจฉัย</label><textarea id="diagnosis" name="diagnosis" rows="3" class="form-control">{{ old('diagnosis', $appointment->diagnosis) }}</textarea></div>
        </div>
        <div class="d-flex gap-2 mt-4"><button class="btn btn-primary">{{ auth()->user()->isDoctor() ? 'บันทึกข้อมูลการตรวจ' : 'บันทึกนัดหมาย' }}</button><a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">ยกเลิก</a></div>
    </form>
    @endif
</section>
@endsection
