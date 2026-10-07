@extends('layouts.app')

@section('title', $doctor->exists ? 'แก้ไขแพทย์' : 'เพิ่มแพทย์')
@section('heading', $doctor->exists ? 'แก้ไขข้อมูลแพทย์' : 'เพิ่มแพทย์ใหม่')
@section('subheading', 'กรอกข้อมูลแพทย์ให้ครบถ้วน')

@section('content')
<section class="card p-3 p-md-4">
    <form method="POST" action="{{ $doctor->exists ? route('doctors.update', $doctor) : route('doctors.store') }}">
        @csrf
        @if ($doctor->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="first_name">ชื่อ</label><input id="first_name" name="first_name" value="{{ old('first_name', $doctor->first_name) }}" class="form-control @error('first_name') is-invalid @enderror" required>@error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label" for="last_name">นามสกุล</label><input id="last_name" name="last_name" value="{{ old('last_name', $doctor->last_name) }}" class="form-control @error('last_name') is-invalid @enderror" required>@error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label" for="license_no">เลขที่ใบประกอบวิชาชีพ</label><input id="license_no" name="license_no" value="{{ old('license_no', $doctor->license_no) }}" maxlength="20" class="form-control @error('license_no') is-invalid @enderror" required>@error('license_no')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label" for="specialty">ความเชี่ยวชาญ / แผนก</label><input id="specialty" name="specialty" value="{{ old('specialty', $doctor->specialty) }}" maxlength="100" class="form-control @error('specialty') is-invalid @enderror" required>@error('specialty')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label" for="phone">เบอร์โทรศัพท์</label><input id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}" maxlength="15" class="form-control @error('phone') is-invalid @enderror" required>@error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label" for="email">อีเมล</label><input id="email" name="email" type="email" value="{{ old('email', $doctor->email) }}" maxlength="100" class="form-control @error('email') is-invalid @enderror">@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
        <div class="border-top mt-4 pt-4">
            <h2 class="section-title h6 mb-1">บัญชีเข้าสู่ระบบแพทย์</h2>
            <p class="text-secondary small">แพทย์จะใช้บัญชีนี้เพื่อดูนัดหมายและบันทึกข้อมูลเฉพาะผู้ป่วยที่ได้รับมอบหมาย</p>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="account_email">อีเมลสำหรับเข้าสู่ระบบ</label>
                    <input id="account_email" name="account_email" type="email" value="{{ old('account_email', $account?->email) }}" class="form-control @error('account_email') is-invalid @enderror" autocomplete="off" required>
                    @error('account_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="account_password">{{ $account ? 'ตั้งรหัสผ่านใหม่ (เว้นว่างหากไม่เปลี่ยน)' : 'รหัสผ่านเริ่มต้น' }}</label>
                    <input id="account_password" name="account_password" type="password" minlength="8" class="form-control @error('account_password') is-invalid @enderror" autocomplete="new-password" {{ $account ? '' : 'required' }}>
                    @error('account_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">อย่างน้อย 8 ตัวอักษร</div>
                </div>
            </div>
            @if ($account)
                <div class="small text-success mt-2">บัญชีแพทย์เปิดใช้งานแล้ว: {{ $account->email }}</div>
            @else
                <div class="form-text mt-2">ระบบจะสร้างบัญชีแพทย์เมื่อกรอกอีเมลและรหัสผ่านครบ</div>
            @endif
        </div>
        <div class="d-flex gap-2 mt-4"><button class="btn btn-primary">บันทึกข้อมูล</button><a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary">ยกเลิก</a></div>
    </form>
</section>
@endsection
