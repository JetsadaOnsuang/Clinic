<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ตรวจสอบสถานะนัดหมาย | ClinicCare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --clinic-ink:#203b48; --clinic-muted:#70858d; --clinic-primary:#168b83; --clinic-primary-dark:#11736d; --clinic-soft:#e8f5f3; --clinic-border:#e3eceb; }
        body,button,input,select,textarea { font-family:'Sarabun','Noto Sans Thai',Tahoma,sans-serif; }
        body { min-height:100vh; color:var(--clinic-ink); background:radial-gradient(ellipse at 12% 5%,#e4f4f1 0,transparent 36%),radial-gradient(ellipse at 95% 95%,#e7f1f5 0,transparent 34%),#f5f9f9; }
        .status-card { width:min(100%,680px); border:1px solid var(--clinic-border); border-radius:1.25rem; box-shadow:0 18px 55px rgba(29,73,78,.08); }
        .login-mark { display:flex; align-items:center; justify-content:center; width:54px; height:54px; margin:0 auto 1rem; border-radius:17px; background:var(--clinic-soft); color:var(--clinic-primary-dark); font-size:1.65rem; font-weight:700; }
        .brand-name { color:var(--clinic-primary-dark); font-weight:750; letter-spacing:-.02em; }
        .form-label { color:#425c65; font-size:.9rem; font-weight:650; }
        .form-control { min-height:44px; border-color:#dce7e6; border-radius:.65rem; }
        .btn-primary { --bs-btn-bg:var(--clinic-primary); --bs-btn-border-color:var(--clinic-primary); --bs-btn-hover-bg:var(--clinic-primary-dark); --bs-btn-hover-border-color:var(--clinic-primary-dark); border-radius:.65rem; font-weight:650; }
        .text-secondary { color:var(--clinic-muted)!important; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">
<main class="status-card card p-4 p-md-5">
    <div class="text-center mb-4">
        <div class="login-mark" aria-hidden="true">+</div>
        <div class="brand-name fs-4">ClinicCare</div>
        <h1 class="h4 fw-bold mt-3">ตรวจสอบสถานะนัดหมาย</h1>
        <p class="text-secondary mb-0">ผู้ป่วยตรวจสอบนัดหมายของตนเองได้โดยไม่ต้องเข้าสู่ระบบ</p>
    </div>

    <div class="alert alert-info small" role="note">
        เพื่อยืนยันตัวตน กรุณาใช้เลขบัตรประชาชนและเบอร์โทรศัพท์ที่แจ้งไว้กับคลินิก ระบบจะแสดงเฉพาะวันนัด แพทย์ และสถานะนัดหมาย
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('appointment-status.lookup') }}">
        @csrf
        <div class="mb-3">
            <label for="id_card" class="form-label">เลขบัตรประชาชน 13 หลัก</label>
            <input id="id_card" name="id_card" type="text" inputmode="numeric" pattern="[0-9]{13}" maxlength="13" class="form-control @error('id_card') is-invalid @enderror" value="{{ old('id_card') }}" required autocomplete="off">
            @error('id_card')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label for="phone" class="form-label">เบอร์โทรศัพท์ที่ลงทะเบียน</label>
            <input id="phone" name="phone" type="tel" maxlength="15" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required autocomplete="tel">
            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <button class="btn btn-primary w-100 py-2">ค้นหานัดหมายของฉัน</button>
    </form>

    @isset($patient)
        <section class="border-top mt-4 pt-4" aria-live="polite">
            <h2 class="h6 fw-bold mb-1">นัดหมายของ {{ $patient->first_name }} {{ $patient->last_name }}</h2>
            @if ($appointments->isEmpty())
                <p class="text-secondary mb-0">ยังไม่มีข้อมูลนัดหมาย</p>
            @else
                <div class="table-responsive mt-3">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th>วันและเวลา</th><th>แพทย์</th><th>แผนก</th><th>สถานะ</th></tr></thead>
                        <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td class="text-nowrap">{{ $appointment->appointment_date->format('d/m/Y H:i') }}</td>
                                <td>นพ. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
                                <td>{{ $appointment->doctor->specialty }}</td>
                                <td>
                                    @php($statusClass = ['Pending' => 'text-bg-warning', 'Completed' => 'text-bg-success', 'Cancelled' => 'text-bg-secondary'][$appointment->status])
                                    <span class="badge {{ $statusClass }}">{{ ['Pending' => 'รอตรวจ', 'Completed' => 'ตรวจแล้ว', 'Cancelled' => 'ยกเลิก'][$appointment->status] }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    @endisset

    <div class="text-center border-top mt-4 pt-3">
        <a href="{{ route('login') }}" class="link-secondary">เข้าสู่ระบบสำหรับผู้ดูแลและแพทย์</a>
    </div>
</main>
</body>
</html>
