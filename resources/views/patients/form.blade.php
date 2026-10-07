@extends('layouts.app')

@section('title', $patient->exists ? 'แก้ไขผู้ป่วย' : 'เพิ่มผู้ป่วย')
@section('heading', $patient->exists ? 'แก้ไขข้อมูลผู้ป่วย' : 'เพิ่มผู้ป่วยใหม่')
@section('subheading', 'กรอกข้อมูลที่จำเป็นให้ครบถ้วน')

@section('content')
<section class="card p-3 p-md-4">
    <form method="POST" action="{{ $patient->exists ? route('patients.update', $patient) : route('patients.store') }}">
        @csrf
        @if ($patient->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="first_name">ชื่อ</label><input id="first_name" name="first_name" value="{{ old('first_name', $patient->first_name) }}" class="form-control @error('first_name') is-invalid @enderror" required>@error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label" for="last_name">นามสกุล</label><input id="last_name" name="last_name" value="{{ old('last_name', $patient->last_name) }}" class="form-control @error('last_name') is-invalid @enderror" required>@error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label" for="id_card">เลขบัตรประชาชน 13 หลัก</label><input id="id_card" name="id_card" value="{{ old('id_card', $patient->id_card) }}" maxlength="13" class="form-control @error('id_card') is-invalid @enderror" required>@error('id_card')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label" for="phone">เบอร์โทรศัพท์</label><input id="phone" name="phone" value="{{ old('phone', $patient->phone) }}" maxlength="15" class="form-control @error('phone') is-invalid @enderror" required>@error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-4"><label class="form-label" for="dob">วันเกิด</label><input id="dob" name="dob" type="date" value="{{ old('dob', $patient->dob?->format('Y-m-d')) }}" class="form-control @error('dob') is-invalid @enderror" required>@error('dob')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-4"><label class="form-label" for="gender">เพศ</label><select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required><option value="">เลือกเพศ</option>@foreach (['Male' => 'ชาย', 'Female' => 'หญิง', 'Other' => 'อื่น ๆ'] as $value => $label)<option value="{{ $value }}" @selected(old('gender', $patient->gender) === $value)>{{ $label }}</option>@endforeach</select>@error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-4"><label class="form-label" for="blood_group">กรุ๊ปเลือด</label><select id="blood_group" name="blood_group" class="form-select"><option value="">ไม่ระบุ</option>@foreach (['A', 'B', 'AB', 'O'] as $group)<option value="{{ $group }}" @selected(old('blood_group', $patient->blood_group) === $group)>{{ $group }}</option>@endforeach</select></div>
            <div class="col-12"><label class="form-label" for="address">ที่อยู่</label><textarea id="address" name="address" rows="2" class="form-control">{{ old('address', $patient->address) }}</textarea></div>
            <div class="col-12"><label class="form-label" for="allergies">ประวัติแพ้ยา</label><textarea id="allergies" name="allergies" rows="2" class="form-control">{{ old('allergies', $patient->allergies) }}</textarea></div>
        </div>
        <div class="d-flex gap-2 mt-4"><button class="btn btn-primary">บันทึกข้อมูล</button><a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">ยกเลิก</a></div>
    </form>
</section>
@endsection
