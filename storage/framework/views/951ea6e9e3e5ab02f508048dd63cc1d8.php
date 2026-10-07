

<?php $__env->startSection('title', 'นัดหมาย'); ?>
<?php $__env->startSection('heading', 'จัดการนัดหมาย'); ?>
<?php $__env->startSection('subheading', 'ติดตามคิวตรวจและบันทึกผลการวินิจฉัย'); ?>

<?php $__env->startSection('content'); ?>
<section class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <form method="GET" class="d-flex flex-wrap gap-2">
            <input name="q" value="<?php echo e($term); ?>" class="form-control" placeholder="ค้นหาชื่อผู้ป่วย แพทย์ หรืออาการ" aria-label="ค้นหานัดหมาย">
            <select name="status" class="form-select" aria-label="กรองตามสถานะ">
                <option value="">ทุกสถานะ</option>
                <?php $__currentLoopData = ['Pending' => 'รอตรวจ', 'Completed' => 'ตรวจแล้ว', 'Cancelled' => 'ยกเลิก']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value); ?>" <?php if(request('status') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button class="btn btn-outline-primary">ค้นหา / กรอง</button>
            <?php if($term !== '' || request()->filled('status')): ?>
                <a href="<?php echo e(route('appointments.index')); ?>" class="btn btn-outline-secondary">ล้างตัวกรอง</a>
            <?php endif; ?>
        </form>
        <?php if(auth()->user()->isAdmin()): ?><a href="<?php echo e(route('appointments.create')); ?>" class="btn btn-primary">+ เพิ่มนัดหมาย</a><?php endif; ?>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-3">
            <thead><tr><th>วันและเวลา</th><th>ผู้ป่วย</th><th>แพทย์</th><th>อาการ</th><th>สถานะ</th><th class="text-end">จัดการ</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($appointment->appointment_date->format('d/m/Y H:i')); ?></td>
                    <td><?php echo e($appointment->patient->first_name); ?> <?php echo e($appointment->patient->last_name); ?></td>
                    <td>นพ. <?php echo e($appointment->doctor->first_name); ?> <?php echo e($appointment->doctor->last_name); ?></td>
                    <td><?php echo e(\Illuminate\Support\Str::limit($appointment->symptoms, 32)); ?></td>
                    <td><span class="badge <?php echo e($appointment->status === 'Completed' ? 'text-bg-success' : ($appointment->status === 'Cancelled' ? 'text-bg-secondary' : 'text-bg-warning')); ?>"><?php echo e(['Pending' => 'รอตรวจ', 'Completed' => 'ตรวจแล้ว', 'Cancelled' => 'ยกเลิก'][$appointment->status]); ?></span></td>
                    <td class="text-end text-nowrap">
                        <a href="<?php echo e(route('appointments.show', $appointment)); ?>" class="btn btn-sm btn-outline-secondary">ดู</a>
                        <a href="<?php echo e(route('appointments.edit', $appointment)); ?>" class="btn btn-sm btn-outline-primary">แก้ไข</a>
                        <?php if(auth()->user()->isAdmin()): ?><form action="<?php echo e(route('appointments.destroy', $appointment)); ?>" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบนัดหมายนี้?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger">ลบ</button></form><?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-secondary py-4">ไม่พบนัดหมาย</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($appointments->links()); ?>

</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\EDB project\6714421008\resources\views/appointments/index.blade.php ENDPATH**/ ?>