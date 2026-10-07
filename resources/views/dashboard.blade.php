@extends('layouts.app')

@section('title', 'ภาพรวม')
@section('heading', 'ภาพรวมคลินิก')
@section('subheading', auth()->user()->isAdmin() ? 'สรุปข้อมูลสำคัญและนัดหมายล่าสุด' : 'คิวตรวจและข้อมูลผู้ป่วยที่อยู่ในการดูแลของคุณ')

@section('content')
@if ($isAdmin)
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div class="text-secondary small">เริ่มงานได้ทันที</div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">+ นัดหมายใหม่</a>
        <a href="{{ route('patients.create') }}" class="btn btn-outline-primary">+ ผู้ป่วยใหม่</a>
        <a href="{{ route('doctors.create') }}" class="btn btn-outline-primary">+ แพทย์ใหม่</a>
    </div>
</div>
@endif
<div class="row g-3 mb-4">
    <div class="col-sm-6 {{ $isAdmin ? 'col-xl-3' : 'col-xl-4' }}"><div class="card stat-card p-4" style="--stat-tint:#e4f4f1;--stat-color:#168b83"><div class="d-flex justify-content-between align-items-start"><div><div class="stat-label small fw-semibold">{{ $isAdmin ? 'ผู้ป่วยทั้งหมด' : 'ผู้ป่วยในการดูแล' }}</div><div class="stat-number mt-2">{{ number_format($patientCount) }}</div></div><span class="stat-icon" aria-hidden="true">ผ</span></div></div></div>
    <div class="col-sm-6 {{ $isAdmin ? 'col-xl-3' : 'col-xl-4' }}"><div class="card stat-card p-4" style="--stat-tint:#edf3ff;--stat-color:#5279c6"><div class="d-flex justify-content-between align-items-start"><div><div class="stat-label small fw-semibold">นัดหมายวันนี้</div><div class="stat-number mt-2">{{ number_format($todayCount) }}</div></div><span class="stat-icon" aria-hidden="true">น</span></div></div></div>
    <div class="col-sm-6 {{ $isAdmin ? 'col-xl-3' : 'col-xl-4' }}"><div class="card stat-card p-4" style="--stat-tint:#e8f5ed;--stat-color:#3c9862"><div class="d-flex justify-content-between align-items-start"><div><div class="stat-label small fw-semibold">{{ $isAdmin ? 'แพทย์ที่มีนัดวันนี้' : 'คิวของคุณวันนี้' }}</div><div class="stat-number mt-2">{{ number_format($todayDoctorCount) }}</div></div><span class="stat-icon" aria-hidden="true">{{ $isAdmin ? 'พ' : 'ค' }}</span></div></div></div>
    @if ($isAdmin)<div class="col-sm-6 col-xl-3"><div class="card stat-card p-4" style="--stat-tint:#f0ecfb;--stat-color:#7b67b0"><div class="d-flex justify-content-between align-items-start"><div><div class="stat-label small fw-semibold">แพทย์ในระบบ</div><div class="stat-number mt-2">{{ number_format($doctorCount) }}</div></div><span class="stat-icon" aria-hidden="true">ท</span></div></div></div>@endif
</div>
@if ($isAdmin)
<section id="monthly-stats" class="card p-3 p-md-4 mb-4">
    <div class="mb-3">
        <h2 class="section-title h5 mb-1">สถิติการนัดหมาย 6 เดือนล่าสุด</h2>
        <div class="text-secondary small">จำนวนรายการนัดหมายแยกตามเดือน</div>
    </div>
    <div class="d-flex align-items-end gap-3" style="height: 180px" role="img" aria-label="กราฟแท่งแสดงจำนวนนัดหมายในช่วง 6 เดือนล่าสุด">
        @foreach ($monthlyAppointments as $month)
            <div class="d-flex flex-column align-items-center justify-content-end gap-2 flex-fill h-100">
                <span class="small text-secondary">{{ $month['count'] }}</span>
                <div class="rounded-top w-100" style="background:linear-gradient(180deg,#37aaa0,#168b83);height: {{ (int) round($month['count'] / $maxMonthlyAppointments * 115) }}px"></div>
                <span class="small text-secondary">{{ $month['label'] }}</span>
            </div>
        @endforeach
    </div>
</section>
@endif
<section class="card p-3 p-md-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div><h2 class="section-title h5 mb-1">{{ $isAdmin ? 'นัดหมายล่าสุด' : 'นัดหมายของคุณ' }}</h2><div class="text-secondary small">{{ $isAdmin ? 'รายการนัดหมายที่บันทึกในระบบ' : 'แสดงเฉพาะนัดหมายที่มอบหมายให้คุณ' }}</div></div>
        <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary btn-sm">ดูนัดหมายทั้งหมด</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead><tr><th>วันและเวลา</th><th>ผู้ป่วย</th><th>แพทย์</th><th>อาการ</th><th>สถานะ</th><th class="text-end">จัดการ</th></tr></thead>
            <tbody>
            @forelse ($recentAppointments as $appointment)
                <tr>
                    <td>{{ $appointment->appointment_date->format('d/m/Y H:i') }}</td>
                    <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                    <td>นพ. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($appointment->symptoms, 38) }}</td>
                    <td><span class="badge {{ $appointment->status === 'Completed' ? 'text-bg-success' : ($appointment->status === 'Cancelled' ? 'text-bg-secondary' : 'text-bg-warning') }}">{{ ['Pending' => 'รอตรวจ', 'Completed' => 'ตรวจแล้ว', 'Cancelled' => 'ยกเลิก'][$appointment->status] }}</span></td>
                    <td class="text-end text-nowrap"><a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-outline-secondary">ดู</a> <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-primary">แก้ไข</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-secondary py-4">ยังไม่มีนัดหมาย <a href="{{ route('appointments.create') }}">เพิ่มนัดหมายแรก</a></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
