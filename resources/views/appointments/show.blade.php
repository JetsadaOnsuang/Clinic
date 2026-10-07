@extends('layouts.app')

@section('title', 'รายละเอียดนัดหมาย')
@section('heading', 'รายละเอียดนัดหมาย')
@section('subheading', 'ข้อมูลผู้ป่วย แพทย์ และผลการตรวจ')

@section('content')
<section class="card p-3 p-md-4">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="text-secondary small">สถานะนัดหมาย</div>
            <span class="badge {{ $appointment->status === 'Completed' ? 'text-bg-success' : ($appointment->status === 'Cancelled' ? 'text-bg-secondary' : 'text-bg-warning') }}">{{ ['Pending' => 'รอตรวจ', 'Completed' => 'ตรวจแล้ว', 'Cancelled' => 'ยกเลิก'][$appointment->status] }}</span>
        </div>
        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-primary">{{ auth()->user()->isDoctor() ? 'บันทึกข้อมูลการตรวจ' : 'แก้ไขนัดหมาย' }}</a>
    </div>
    <div class="row g-4">
        <div class="col-md-6">
            <h2 class="section-title h6">ข้อมูลนัดหมาย</h2>
            <dl class="row mb-0">
                <dt class="col-sm-4 text-secondary">วันและเวลา</dt><dd class="col-sm-8">{{ $appointment->appointment_date->format('d/m/Y H:i') }}</dd>
                <dt class="col-sm-4 text-secondary">อาการเบื้องต้น</dt><dd class="col-sm-8">{{ $appointment->symptoms }}</dd>
                <dt class="col-sm-4 text-secondary">ผลวินิจฉัย</dt><dd class="col-sm-8">{{ $appointment->diagnosis ?: 'ยังไม่มีข้อมูล' }}</dd>
            </dl>
        </div>
        <div class="col-md-6">
            <h2 class="section-title h6">ข้อมูลผู้ป่วย</h2>
            <dl class="row mb-0">
                <dt class="col-sm-4 text-secondary">ชื่อ</dt><dd class="col-sm-8">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</dd>
                <dt class="col-sm-4 text-secondary">เลขบัตรประชาชน</dt><dd class="col-sm-8">{{ $appointment->patient->id_card }}</dd>
                <dt class="col-sm-4 text-secondary">เบอร์โทรศัพท์</dt><dd class="col-sm-8">{{ $appointment->patient->phone }}</dd>
            </dl>
        </div>
        <div class="col-md-6">
            <h2 class="section-title h6">ข้อมูลแพทย์</h2>
            <dl class="row mb-0">
                <dt class="col-sm-4 text-secondary">ชื่อ</dt><dd class="col-sm-8">นพ. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</dd>
                <dt class="col-sm-4 text-secondary">ความเชี่ยวชาญ</dt><dd class="col-sm-8">{{ $appointment->doctor->specialty }}</dd>
                <dt class="col-sm-4 text-secondary">เบอร์โทรศัพท์</dt><dd class="col-sm-8">{{ $appointment->doctor->phone }}</dd>
            </dl>
        </div>
    </div>
    <div class="mt-4"><a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">กลับไปหน้ารายการ</a></div>
</section>
@endsection
