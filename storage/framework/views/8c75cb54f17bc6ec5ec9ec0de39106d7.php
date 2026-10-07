<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'ภาพรวม'); ?> | ClinicCare System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --clinic-ink: #203b48;
            --clinic-muted: #70858d;
            --clinic-primary: #168b83;
            --clinic-primary-dark: #11736d;
            --clinic-soft: #e8f5f3;
            --clinic-canvas: #f4f8f8;
            --clinic-border: #e3eceb;
            --bs-primary: var(--clinic-primary);
            --bs-primary-rgb: 22, 139, 131;
            --bs-link-color: var(--clinic-primary-dark);
            --bs-link-hover-color: #0d5d58;
        }
        body,button,input,select,textarea { font-family:'Sarabun','Noto Sans Thai',Tahoma,sans-serif; }
        body { background:var(--clinic-canvas); color:var(--clinic-ink); font-size:.94rem; }
        .shell { min-height:100vh; }
        .sidebar { width:256px; flex:0 0 256px; min-height:100vh; background:#fff; border-right:1px solid var(--clinic-border); }
        .brand { color:var(--clinic-ink); font-size:1.1rem; font-weight:750; letter-spacing:-.02em; }
        .brand-mark { display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; margin-right:.55rem; border-radius:12px; background:var(--clinic-soft); color:var(--clinic-primary-dark); font-size:1.15rem; vertical-align:middle; }
        .nav-caption { color:#98a9ae; font-size:.7rem; font-weight:700; letter-spacing:.09em; }
        .nav-link { color:#60757d; border-radius:.7rem; padding:.72rem .85rem; font-weight:550; transition:background-color .15s ease,color .15s ease; }
        .nav-link:hover { color:var(--clinic-primary-dark); background:#f3f8f7; }
        .nav-link.active { color:var(--clinic-primary-dark); background:var(--clinic-soft); font-weight:700; }
        .sidebar-note { border-top:1px solid var(--clinic-border); color:#91a1a6; }
        .main-area { min-width:0; }
        .topbar { min-height:72px; background:#fff; border-bottom:1px solid var(--clinic-border); }
        .topbar-search { width:min(430px, 48vw); }
        .topbar-search .form-control { padding-right:4.8rem; }
        .search-shortcut { position:absolute; top:50%; right:.6rem; transform:translateY(-50%); padding:.1rem .38rem; border:1px solid var(--clinic-border); border-radius:.35rem; color:#8a9b9f; font-size:.7rem; }
        .search-result { color:var(--clinic-ink); }
        .search-result:hover { color:var(--clinic-primary-dark); background:#f7fbfa; }
        .user-avatar { display:inline-flex; width:34px; height:34px; align-items:center; justify-content:center; border-radius:50%; background:var(--clinic-soft); color:var(--clinic-primary-dark); font-weight:700; }
        main { max-width:1600px; margin:0 auto; }
        .page-heading { color:var(--clinic-ink); letter-spacing:-.025em; }
        .card { border:1px solid var(--clinic-border); border-radius:1rem; background:#fff; box-shadow:0 5px 22px rgba(29,73,78,.035); }
        .stat-card { position:relative; overflow:hidden; min-height:138px; }
        .stat-card::after { position:absolute; right:-20px; bottom:-34px; width:110px; height:110px; border-radius:50%; background:var(--stat-tint, var(--clinic-soft)); content:""; opacity:.68; }
        .stat-label,.text-secondary { color:var(--clinic-muted)!important; }
        .stat-number { position:relative; z-index:1; color:var(--clinic-ink); font-size:2rem; font-weight:750; letter-spacing:-.04em; }
        .stat-icon { position:relative; z-index:1; display:inline-flex; width:38px; height:38px; align-items:center; justify-content:center; border-radius:12px; background:var(--stat-tint, var(--clinic-soft)); color:var(--stat-color, var(--clinic-primary-dark)); font-size:1.05rem; font-weight:700; }
        .btn { border-radius:.65rem; font-weight:600; }
        .btn-primary { --bs-btn-bg:var(--clinic-primary); --bs-btn-border-color:var(--clinic-primary); --bs-btn-hover-bg:var(--clinic-primary-dark); --bs-btn-hover-border-color:var(--clinic-primary-dark); --bs-btn-active-bg:var(--clinic-primary-dark); --bs-btn-active-border-color:var(--clinic-primary-dark); --bs-btn-disabled-bg:var(--clinic-primary); --bs-btn-disabled-border-color:var(--clinic-primary); }
        .btn-outline-primary { --bs-btn-color:var(--clinic-primary-dark); --bs-btn-border-color:#9bcfc9; --bs-btn-hover-bg:var(--clinic-primary); --bs-btn-hover-border-color:var(--clinic-primary); --bs-btn-active-bg:var(--clinic-primary-dark); --bs-btn-active-border-color:var(--clinic-primary-dark); }
        .form-control,.form-select { min-height:42px; border-color:#dce7e6; border-radius:.65rem; color:var(--clinic-ink); }
        textarea.form-control { min-height:auto; }
        .form-control:focus,.form-select:focus { border-color:#72bdb6; box-shadow:0 0 0 .2rem rgba(22,139,131,.13); }
        .form-label { color:#425c65; font-size:.9rem; font-weight:650; }
        .table { --bs-table-color:var(--clinic-ink); --bs-table-bg:transparent; --bs-table-striped-bg:#f7faf9; --bs-table-hover-bg:#f1f8f7; }
        .table > :not(caption) > * > * { padding:.88rem .75rem; border-bottom-color:#edf2f1; }
        .table thead th { background:#f6f9f9; color:#6e838a; font-size:.76rem; font-weight:700; letter-spacing:.035em; white-space:nowrap; }
        .badge { padding:.48em .72em; border-radius:999px; font-weight:650; }
        .pagination { --bs-pagination-color:var(--clinic-primary-dark); --bs-pagination-hover-color:var(--clinic-primary-dark); --bs-pagination-focus-box-shadow:0 0 0 .2rem rgba(22,139,131,.13); --bs-pagination-active-bg:var(--clinic-primary); --bs-pagination-active-border-color:var(--clinic-primary); --bs-pagination-border-color:var(--clinic-border); }
        .alert { border:0; border-radius:.8rem; }
        .section-title { color:var(--clinic-ink); font-weight:700; }
        @media(max-width:767.98px) {
            .sidebar { width:100%; min-height:auto; border-right:0; border-bottom:1px solid var(--clinic-border); }
            .shell { display:block!important; }
            .sidebar .nav { display:flex; flex-direction:row!important; flex-wrap:wrap; }
            .sidebar .nav-link { padding:.5rem .65rem; }
            .sidebar-note { display:none; }
            .topbar { min-height:60px; padding:.75rem 1rem!important; flex-wrap:wrap; }
            main { padding:1.2rem!important; }
            .topbar-search { order:2; width:100%; margin:0!important; }
            .topbar-search .form-control { padding-right:.75rem; }
            .search-shortcut { display:none; }
            .account-actions { order:1; }
        }
    </style>
</head>
<body>
<div class="shell d-flex">
    <aside class="sidebar p-3">
        <a href="<?php echo e(route('dashboard')); ?>" class="brand text-decoration-none d-block px-2 py-3"><span class="brand-mark">+</span>ClinicCare</a>
        <div class="nav-caption px-2 mt-3 mb-2">เมนูหลัก</div>
        <nav class="nav flex-column gap-1">
            <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">ภาพรวม</a>
            <?php if(auth()->user()->isAdmin()): ?>
                <a class="nav-link <?php echo e(request()->routeIs('patients.*') ? 'active' : ''); ?>" href="<?php echo e(route('patients.index')); ?>">ผู้ป่วย</a>
                <a class="nav-link <?php echo e(request()->routeIs('doctors.*') ? 'active' : ''); ?>" href="<?php echo e(route('doctors.index')); ?>">แพทย์</a>
            <?php endif; ?>
            <a class="nav-link <?php echo e(request()->routeIs('appointments.*') ? 'active' : ''); ?>" href="<?php echo e(route('appointments.index')); ?>">นัดหมาย</a>
            <?php if(auth()->user()->isAdmin()): ?>
                <a class="nav-link" href="<?php echo e(route('dashboard')); ?>#monthly-stats">กราฟสถิติ</a>
            <?php endif; ?>
        </nav>
        <div class="sidebar-note small px-2 pt-3 mt-5">ระบบจัดการคลินิก<br><span class="small">ClinicCare System</span></div>
    </aside>
    <div class="main-area flex-grow-1">
        <header class="topbar px-4 py-3 d-flex justify-content-between align-items-center gap-3">
            <form action="<?php echo e(route('search')); ?>" method="GET" class="topbar-search position-relative" role="search">
                <input id="global-search" class="form-control form-control-sm" name="q" value="<?php echo e(request()->routeIs('search') ? request('q') : ''); ?>" placeholder="ค้นหาผู้ป่วย แพทย์ หรือนัดหมาย..." aria-label="ค้นหาทั้งระบบ" autocomplete="off">
                <kbd class="search-shortcut" aria-hidden="true">/</kbd>
            </form>
            <div class="account-actions ms-auto d-flex align-items-center gap-3">
                <span class="user-avatar" aria-hidden="true"><?php echo e(mb_substr(auth()->user()->name, 0, 1)); ?></span>
                <span class="d-none d-sm-inline"><span class="text-secondary"><?php echo e(auth()->user()->name); ?></span><span class="badge text-bg-light ms-1"><?php echo e(auth()->user()->isAdmin() ? 'ผู้ดูแล' : 'แพทย์'); ?></span></span>
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-outline-secondary btn-sm">ออกจากระบบ</button>
                </form>
            </div>
        </header>
        <main class="p-4">
            <div class="mb-4">
                <h1 class="page-heading h3 fw-bold mb-1"><?php echo $__env->yieldContent('heading'); ?></h1>
                <div class="text-secondary"><?php echo $__env->yieldContent('subheading'); ?></div>
            </div>
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="ปิด"></button></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert"><?php echo e(session('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="ปิด"></button></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger" role="alert">
                    <strong>บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบ:</strong>
                    <ul class="mb-0 mt-2"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                </div>
            <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('keydown', (event) => {
        if (event.key !== '/' || event.ctrlKey || event.metaKey || event.altKey) return;
        if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement?.tagName)) return;
        event.preventDefault();
        document.getElementById('global-search')?.focus();
    });
</script>
</body>
</html>
<?php /**PATH E:\EDB project\6714421008\resources\views/layouts/app.blade.php ENDPATH**/ ?>