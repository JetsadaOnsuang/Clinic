

<?php $__env->startSection('title', 'รายละเอียดนัดหมาย'); ?>
<?php $__env->startSection('heading', 'รายละเอียดนัดหมาย'); ?>
<?php $__env->startSection('subheading', 'ข้อมูลผู้ป่วย แพทย์ และผลการตรวจ'); ?>

<?php $__env->startSection('content'); ?>
<section class="card p-3 p-md-4">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="text-secondary small">สถานะนัดหมาย</div>
            <span class="badge <?php echo e($appointment->status === 'Completed' ? 'text-bg-success' : ($appointment->status === 'Cancelled' ? 'text-bg-secondary' : 'text-bg-warning')); ?>"><?php echo e(['Pending' => 'รอตรวจ', 'Completed' => 'ตรวจแล้ว', 'Cancelled' => 'ยกเลิก'][$appointment->status]); ?></span>
        </div>
        <a href="<?php echo e(route('appointments.edit', $appointment)); ?>" class="btn btn-primary"><?php echo e(auth()->user()->isDoctor() ? 'บันทึกข้อมูลการตรวจ' : 'แก้ไขนัดหมาย'); ?></a>
    </div>
    <div class="row g-4">
        <div class="col-md-6">
            <h2 class="section-title h6">ข้อมูลนัดหมาย</h2>
            <dl class="row mb-0">
                <dt class="col-sm-4 text-secondary">วันและเวลา</dt><dd class="col-sm-8"><?php echo e($appointment->appointment_date->format('d/m/Y H:i')); ?></dd>
                <dt class="col-sm-4 text-secondary">อาการเบื้องต้น</dt><dd class="col-sm-8"><?php echo e($appointment->symptoms); ?></dd>
                <dt class="col-sm-4 text-secondary">ผลวินิจฉัย</dt><dd class="col-sm-8"><?php echo e($appointment->diagnosis ?: 'ยังไม่มีข้อมูล'); ?></dd>
            </dl>
        </div>
        <div class="col-md-6">
            <h2 class="section-title h6">ข้อมูลผู้ป่วย</h2>
            <dl class="row mb-0">
                <dt class="col-sm-4 text-secondary">ชื่อ</dt><dd class="col-sm-8"><?php echo e($appointment->patient->first_name); ?> <?php echo e($appointment->patient->last_name); ?></dd>
                <dt class="col-sm-4 text-secondary">เลขบัตรประชาชน</dt><dd class="col-sm-8"><?php echo e($appointment->patient->id_card); ?></dd>
                <dt class="col-sm-4 text-secondary">เบอร์โทรศัพท์</dt><dd class="col-sm-8"><?php echo e($appointment->patient->phone); ?></dd>
            </dl>
        </div>
        <div class="col-md-6">
            <h2 class="section-title h6">ข้อมูลแพทย์</h2>
            <dl class="row mb-0">
                <dt class="col-sm-4 text-secondary">ชื่อ</dt><dd class="col-sm-8">นพ. <?php echo e($appointment->doctor->first_name); ?> <?php echo e($appointment->doctor->last_name); ?></dd>
                <dt class="col-sm-4 text-secondary">ความเชี่ยวชาญ</dt><dd class="col-sm-8"><?php echo e($appointment->doctor->specialty); ?></dd>
                <dt class="col-sm-4 text-secondary">เบอร์โทรศัพท์</dt><dd class="col-sm-8"><?php echo e($appointment->doctor->phone); ?></dd>
            </dl>
        </div>
    </div>
    <div class="mt-4"><a href="<?php echo e(route('appointments.index')); ?>" class="btn btn-outline-secondary">กลับไปหน้ารายการ</a></div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\EDB project\6714421008\resources\views/appointments/show.blade.php ENDPATH**/ ?>