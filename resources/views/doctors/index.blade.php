@extends('layouts.app')

@section('title', 'แพทย์')
@section('heading', 'จัดการข้อมูลแพทย์')
@section('subheading', 'ทะเบียนแพทย์และข้อมูลติดต่อ')

@section('content')
<section class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <form method="GET" class="d-flex gap-2">
            <input name="q" value="{{ $search }}" class="form-control" placeholder="ชื่อ ความเชี่ยวชาญ หรือเลขใบอนุญาต" aria-label="ค้นหาแพทย์">
            <button class="btn btn-outline-primary">ค้นหา</button>
            @if ($search !== '')<a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary">ล้าง</a>@endif
        </form>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary">+ เพิ่มแพทย์</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-3">
            <thead><tr><th>ชื่อ - นามสกุล</th><th>เลขใบอนุญาต</th><th>ความเชี่ยวชาญ</th><th>ชื่อบัญชี / อีเมลเข้าสู่ระบบ</th><th>เบอร์โทรศัพท์</th><th class="text-end">จัดการ</th></tr></thead>
            <tbody>
            @forelse ($doctors as $doctor)
                <tr>
                    <td class="fw-semibold">นพ. {{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                    <td>{{ $doctor->license_no }}</td><td>{{ $doctor->specialty }}</td><td><span class="d-block">{{ $doctor->user?->name ?? 'ยังไม่มีบัญชี' }}</span><span class="small text-secondary">{{ $doctor->user?->email ?? 'ยังไม่มีบัญชี' }}</span></td><td>{{ $doctor->phone }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-outline-primary">แก้ไข</a>
                        <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="d-inline" onsubmit="return confirm('การลบแพทย์จะลบนัดหมายที่เกี่ยวข้องด้วย ยืนยันหรือไม่?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">ลบ</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-secondary py-4">ไม่พบข้อมูลแพทย์</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $doctors->links() }}
</section>
@endsection
