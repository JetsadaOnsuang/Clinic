@extends('layouts.app')

@section('title', 'ค้นหาทั้งระบบ')
@section('heading', 'ค้นหาทั้งระบบ')
@section('subheading', 'ค้นหาผู้ป่วย แพทย์ และรายการนัดหมายจากที่เดียว')

@section('content')
<section class="card p-3 p-md-4 mb-4">
    <form action="{{ route('search') }}" method="GET" class="d-flex flex-column flex-sm-row gap-2">
        <input id="page-search" name="q" value="{{ $term }}" class="form-control" placeholder="ลองค้นหาด้วยชื่อ เลขบัตร เบอร์โทร หรืออาการ..." aria-label="คำค้นหา" autofocus>
        <button class="btn btn-primary px-4">ค้นหา</button>
        @if ($term !== '')<a href="{{ route('search') }}" class="btn btn-outline-secondary">ล้าง</a>@endif
    </form>
    @if ($term === '')
        <div class="small text-secondary mt-2">เคล็ดลับ: กด <kbd>/</kbd> เพื่อเริ่มค้นหาจากหน้าใดก็ได้</div>
    @endif
</section>

@if ($term !== '')
    <div class="small text-secondary mb-3">ผลการค้นหาสำหรับ <strong class="text-body">“{{ $term }}”</strong></div>
    <div class="row g-3">
        <div class="col-12 col-xl-6">
            <section class="card p-3 p-md-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title h5 mb-0">ผู้ป่วย</h2>
                    @if (auth()->user()->isAdmin())<a href="{{ route('patients.index', ['q' => $term]) }}" class="small">ดูรายการทั้งหมด</a>@endif
                </div>
                @forelse ($patients as $patient)
                    <a href="{{ auth()->user()->isAdmin() ? route('patients.edit', $patient) : route('appointments.index', ['q' => $patient->first_name.' '.$patient->last_name]) }}" class="search-result d-flex justify-content-between align-items-center gap-3 text-decoration-none border-top py-3">
                        <span><strong class="d-block">{{ $patient->first_name }} {{ $patient->last_name }}</strong><span class="small text-secondary">{{ $patient->id_card }} · {{ $patient->phone }}</span></span>
                        <span class="small">เปิดข้อมูล →</span>
                    </a>
                @empty
                    <p class="text-secondary small mb-0">ไม่พบผู้ป่วยที่ตรงกับคำค้น</p>
                @endforelse
            </section>
        </div>
        <div class="col-12 col-xl-6">
            <section class="card p-3 p-md-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title h5 mb-0">แพทย์</h2>
                    @if (auth()->user()->isAdmin())<a href="{{ route('doctors.index', ['q' => $term]) }}" class="small">ดูรายการทั้งหมด</a>@endif
                </div>
                @forelse ($doctors as $doctor)
                    <a href="{{ auth()->user()->isAdmin() ? route('doctors.edit', $doctor) : route('dashboard') }}" class="search-result d-flex justify-content-between align-items-center gap-3 text-decoration-none border-top py-3">
                        <span><strong class="d-block">นพ. {{ $doctor->first_name }} {{ $doctor->last_name }}</strong><span class="small text-secondary">{{ $doctor->specialty }} · {{ $doctor->license_no }}</span></span>
                        <span class="small">เปิดข้อมูล →</span>
                    </a>
                @empty
                    <p class="text-secondary small mb-0">ไม่พบแพทย์ที่ตรงกับคำค้น</p>
                @endforelse
            </section>
        </div>
        <div class="col-12">
            <section class="card p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title h5 mb-0">นัดหมาย</h2>
                    <a href="{{ route('appointments.index', ['q' => $term]) }}" class="small">ดูรายการทั้งหมด</a>
                </div>
                @forelse ($appointments as $appointment)
                    <a href="{{ route('appointments.show', $appointment) }}" class="search-result d-flex flex-wrap justify-content-between align-items-center gap-2 border-top py-3 text-decoration-none">
                        <span><strong class="d-block">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }} <span class="text-secondary fw-normal">กับ นพ. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</span></strong><span class="small text-secondary">{{ $appointment->appointment_date->format('d/m/Y H:i') }} · {{ \Illuminate\Support\Str::limit($appointment->symptoms, 70) }}</span></span>
                        <span class="small">ดูนัดหมาย →</span>
                    </a>
                @empty
                    <p class="text-secondary small mb-0">ไม่พบนัดหมายที่ตรงกับคำค้น</p>
                @endforelse
            </section>
        </div>
    </div>
@endif
@endsection
