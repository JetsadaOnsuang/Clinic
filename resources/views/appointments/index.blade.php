@extends('layouts.app')

@section('title', 'นัดหมาย')
@section('heading', 'จัดการนัดหมาย')
@section('subheading', 'ติดตามคิวตรวจและบันทึกผลการวินิจฉัย')

@section('content')
<section class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <form method="GET" class="d-flex flex-wrap gap-2">
            <input name="q" value="{{ $term }}" class="form-control" placeholder="ค้นหาชื่อผู้ป่วย แพทย์ หรืออาการ" aria-label="ค้นหานัดหมาย">
            <select name="status" class="form-select" aria-label="กรองตามสถานะ">
                <option value="">ทุกสถานะ</option>
                @foreach (['Pending' => 'รอตรวจ', 'Completed' => 'ตรวจแล้ว', 'Cancelled' => 'ยกเลิก'] as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline-primary">ค้นหา / กรอง</button>
            @if ($term !== '' || request()->filled('status'))
                <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">ล้างตัวกรอง</a>
            @endif
        </form>
        @if (auth()->user()->isAdmin())<a href="{{ route('appointments.create') }}" class="btn btn-primary">+ เพิ่มนัดหมาย</a>@endif
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-3">
            <thead><tr><th>วันและเวลา</th><th>ผู้ป่วย</th><th>แพทย์</th><th>อาการ</th><th>สถานะ</th><th class="text-end">จัดการ</th></tr></thead>
            <tbody>
            @forelse ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->appointment_date->format('d/m/Y H:i') }}</td>
                    <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                    <td>นพ. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($appointment->symptoms, 32) }}</td>
                    <td><span class="badge {{ $appointment->status === 'Completed' ? 'text-bg-success' : ($appointment->status === 'Cancelled' ? 'text-bg-secondary' : 'text-bg-warning') }}">{{ ['Pending' => 'รอตรวจ', 'Completed' => 'ตรวจแล้ว', 'Cancelled' => 'ยกเลิก'][$appointment->status] }}</span></td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-outline-secondary">ดู</a>
                        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-primary">แก้ไข</a>
                        @if (auth()->user()->isAdmin())<form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบนัดหมายนี้?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">ลบ</button></form>@endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-secondary py-4">ไม่พบนัดหมาย</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $appointments->links() }}
</section>
@endsection
