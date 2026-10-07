<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เข้าสู่ระบบ | ClinicCare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --clinic-ink:#203b48; --clinic-muted:#70858d; --clinic-primary:#168b83; --clinic-primary-dark:#11736d; --clinic-soft:#e8f5f3; --clinic-border:#e3eceb; }
        body,button,input,select,textarea { font-family:'Sarabun','Noto Sans Thai',Tahoma,sans-serif; }
        body { min-height:100vh; color:var(--clinic-ink); background:radial-gradient(ellipse at 12% 5%,#e4f4f1 0,transparent 36%),radial-gradient(ellipse at 95% 95%,#e7f1f5 0,transparent 34%),#f5f9f9; }
        .login-card { width:min(100%,440px); border:1px solid var(--clinic-border); border-radius:1.25rem; box-shadow:0 18px 55px rgba(29,73,78,.08); }
        .login-mark { display:flex; align-items:center; justify-content:center; width:54px; height:54px; margin:0 auto 1rem; border-radius:17px; background:var(--clinic-soft); color:var(--clinic-primary-dark); font-size:1.65rem; font-weight:700; }
        .brand-name { color:var(--clinic-primary-dark); font-weight:750; letter-spacing:-.02em; }
        .form-label { color:#425c65; font-size:.9rem; font-weight:650; }
        .form-control { min-height:44px; border-color:#dce7e6; border-radius:.65rem; }
        .form-control:focus { border-color:#72bdb6; box-shadow:0 0 0 .2rem rgba(22,139,131,.13); }
        .form-check-input:checked { background-color:var(--clinic-primary); border-color:var(--clinic-primary); }
        .btn-primary { --bs-btn-bg:var(--clinic-primary); --bs-btn-border-color:var(--clinic-primary); --bs-btn-hover-bg:var(--clinic-primary-dark); --bs-btn-hover-border-color:var(--clinic-primary-dark); border-radius:.65rem; font-weight:650; }
        .text-secondary { color:var(--clinic-muted)!important; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">
<main class="login-card card p-4 p-md-5">
    <div class="text-center mb-4">
        <div class="login-mark" aria-hidden="true">+</div>
        <div class="brand-name fs-4">ClinicCare</div>
        <h1 class="h4 fw-bold mt-3">เข้าสู่ระบบผู้ดูแล</h1>
        <p class="text-secondary mb-0">เข้าสู่ระบบสำหรับผู้ดูแลหรือแพทย์</p>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">อีเมล</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">รหัสผ่าน</label>
            <input id="password" name="password" type="password" class="form-control" required autocomplete="current-password">
        </div>
        <div class="form-check mb-4">
            <input id="remember" name="remember" type="checkbox" class="form-check-input">
            <label for="remember" class="form-check-label">จดจำฉัน</label>
        </div>
        <button class="btn btn-primary w-100 py-2">เข้าสู่ระบบ</button>
    </form>
    <div class="text-center border-top mt-4 pt-3">
        <a href="{{ route('appointment-status.create') }}" class="link-secondary">ผู้ป่วยทั่วไป: ค้นหา/ตรวจสอบสถานะนัดหมาย</a>
    </div>
</main>
</body>
</html>
