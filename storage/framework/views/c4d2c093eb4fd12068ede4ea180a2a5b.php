

<?php $__env->startSection('title', 'ค้นหาทั้งระบบ'); ?>
<?php $__env->startSection('heading', 'ค้นหาทั้งระบบ'); ?>
<?php $__env->startSection('subheading', 'ค้นหาผู้ป่วย แพทย์ และรายการนัดหมายจากที่เดียว'); ?>

<?php $__env->startSection('content'); ?>
<section class="card p-3 p-md-4 mb-4">
    <form action="<?php echo e(route('search')); ?>" method="GET" class="d-flex flex-column flex-sm-row gap-2">
        <input id="page-search" name="q" value="<?php echo e($term); ?>" class="form-control" placeholder="ลองค้นหาด้วยชื่อ เลขบัตร เบอร์โทร หรืออาการ..." aria-label="คำค้นหา" autofocus>
        <button class="btn btn-primary px-4">ค้นหา</button>
        <?php if($term !== ''): ?><a href="<?php echo e(route('search')); ?>" class="btn btn-outline-secondary">ล้าง</a><?php endif; ?>
    </form>
    <?php if($term === ''): ?>
        <div class="small text-secondary mt-2">เคล็ดลับ: กด <kbd>/</kbd> เพื่อเริ่มค้นหาจากหน้าใดก็ได้</div>
    <?php endif; ?>
</section>

<?php if($term !== ''): ?>
    <div class="small text-secondary mb-3">ผลการค้นหาสำหรับ <strong class="text-body">“<?php echo e($term); ?>”</strong></div>
    <div class="row g-3">
        <div class="col-12 col-xl-6">
            <section class="card p-3 p-md-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title h5 mb-0">ผู้ป่วย</h2>
                    <?php if(auth()->user()->isAdmin()): ?><a href="<?php echo e(route('patients.index', ['q' => $term])); ?>" class="small">ดูรายการทั้งหมด</a><?php endif; ?>
                </div>
                <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(auth()->user()->isAdmin() ? route('patients.edit', $patient) : route('appointments.index', ['q' => $patient->first_name.' '.$patient->last_name])); ?>" class="search-result d-flex justify-content-between align-items-center gap-3 text-decoration-none border-top py-3">
                        <span><strong class="d-block"><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></strong><span class="small text-secondary"><?php echo e($patient->id_card); ?> · <?php echo e($patient->phone); ?></span></span>
                        <span class="small">เปิดข้อมูล →</span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-secondary small mb-0">ไม่พบผู้ป่วยที่ตรงกับคำค้น</p>
                <?php endif; ?>
            </section>
        </div>
        <div class="col-12 col-xl-6">
            <section class="card p-3 p-md-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title h5 mb-0">แพทย์</h2>
                    <?php if(auth()->user()->isAdmin()): ?><a href="<?php echo e(route('doctors.index', ['q' => $term])); ?>" class="small">ดูรายการทั้งหมด</a><?php endif; ?>
                </div>
                <?php $__empty_1 = true; $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(auth()->user()->isAdmin() ? route('doctors.edit', $doctor) : route('dashboard')); ?>" class="search-result d-flex justify-content-between align-items-center gap-3 text-decoration-none border-top py-3">
                        <span><strong class="d-block">นพ. <?php echo e($doctor->first_name); ?> <?php echo e($doctor->last_name); ?></strong><span class="small text-secondary"><?php echo e($doctor->specialty); ?> · <?php echo e($doctor->license_no); ?></span></span>
                        <span class="small">เปิดข้อมูล →</span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-secondary small mb-0">ไม่พบแพทย์ที่ตรงกับคำค้น</p>
                <?php endif; ?>
            </section>
        </div>
        <div class="col-12">
            <section class="card p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title h5 mb-0">นัดหมาย</h2>
                    <a href="<?php echo e(route('appointments.index', ['q' => $term])); ?>" class="small">ดูรายการทั้งหมด</a>
                </div>
                <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('appointments.show', $appointment)); ?>" class="search-result d-flex flex-wrap justify-content-between align-items-center gap-2 border-top py-3 text-decoration-none">
                        <span><strong class="d-block"><?php echo e($appointment->patient->first_name); ?> <?php echo e($appointment->patient->last_name); ?> <span class="text-secondary fw-normal">กับ นพ. <?php echo e($appointment->doctor->first_name); ?> <?php echo e($appointment->doctor->last_name); ?></span></strong><span class="small text-secondary"><?php echo e($appointment->appointment_date->format('d/m/Y H:i')); ?> · <?php echo e(\Illuminate\Support\Str::limit($appointment->symptoms, 70)); ?></span></span>
                        <span class="small">ดูนัดหมาย →</span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-secondary small mb-0">ไม่พบนัดหมายที่ตรงกับคำค้น</p>
                <?php endif; ?>
            </section>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\EDB project\6714421008\resources\views/search/index.blade.php ENDPATH**/ ?>