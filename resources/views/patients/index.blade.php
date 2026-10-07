@extends('layouts.app')

@section('title', 'ผู้ป่วย')
@section('heading', 'จัดการข้อมูลผู้ป่วย')
@section('subheading', 'ค้นหา เพิ่ม แก้ไข และดูแลข้อมูลผู้ป่วย')

@section('content')
<section class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <form method="GET" class="d-flex gap-2">
            <input name="q" value="{{ $search }}" class="form-control" placeholder="ชื่อ นามสกุล หรือเลขบัตร" aria-label="ค้นหาผู้ป่วย">
            <button class="btn btn-outline-primary">ค้นหา</button>
            @if ($search !== '')<a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">ล้าง</a>@endif
        </form>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">+ เพิ่มผู้ป่วย</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-3">
            <thead><tr><th>ชื่อ - นามสกุล</th><th>เลขบัตรประชาชน</th><th>เบอร์โทรศัพท์</th><th>กรุ๊ปเลือด</th><th class="text-end">จัดการ</th></tr></thead>
            <tbody>
            @forelse ($patients as $patient)
                <tr>
                    <td class="fw-semibold">{{ $patient->first_name }} {{ $patient->last_name }}</td>
                    <td>{{ $patient->id_card }}</td><td>{{ $patient->phone }}</td><td>{{ $patient->blood_group ?? '-' }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-outline-primary">แก้ไข</a>
                        <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-inline" onsubmit="return confirm('การลบผู้ป่วยจะลบนัดหมายที่เกี่ยวข้องด้วย ยืนยันหรือไม่?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">ลบ</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-secondary py-4">ไม่พบข้อมูลผู้ป่วย</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $patients->links() }}
</section>
@endsection
