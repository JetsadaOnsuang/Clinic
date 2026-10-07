

<?php $__env->startSection('title', 'ผู้ป่วย'); ?>
<?php $__env->startSection('heading', 'จัดการข้อมูลผู้ป่วย'); ?>
<?php $__env->startSection('subheading', 'ค้นหา เพิ่ม แก้ไข และดูแลข้อมูลผู้ป่วย'); ?>

<?php $__env->startSection('content'); ?>
<section class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <form method="GET" class="d-flex gap-2">
            <input name="q" value="<?php echo e($search); ?>" class="form-control" placeholder="ชื่อ นามสกุล หรือเลขบัตร" aria-label="ค้นหาผู้ป่วย">
            <button class="btn btn-outline-primary">ค้นหา</button>
            <?php if($search !== ''): ?><a href="<?php echo e(route('patients.index')); ?>" class="btn btn-outline-secondary">ล้าง</a><?php endif; ?>
        </form>
        <a href="<?php echo e(route('patients.create')); ?>" class="btn btn-primary">+ เพิ่มผู้ป่วย</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-3">
            <thead><tr><th>ชื่อ - นามสกุล</th><th>เลขบัตรประชาชน</th><th>เบอร์โทรศัพท์</th><th>กรุ๊ปเลือด</th><th class="text-end">จัดการ</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="fw-semibold"><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></td>
                    <td><?php echo e($patient->id_card); ?></td><td><?php echo e($patient->phone); ?></td><td><?php echo e($patient->blood_group ?? '-'); ?></td>
                    <td class="text-end text-nowrap">
                        <a href="<?php echo e(route('patients.edit', $patient)); ?>" class="btn btn-sm btn-outline-primary">แก้ไข</a>
                        <form action="<?php echo e(route('patients.destroy', $patient)); ?>" method="POST" class="d-inline" onsubmit="return confirm('การลบผู้ป่วยจะลบนัดหมายที่เกี่ยวข้องด้วย ยืนยันหรือไม่?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger">ลบ</button></form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center text-secondary py-4">ไม่พบข้อมูลผู้ป่วย</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($patients->links()); ?>

</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\EDB project\6714421008\resources\views/patients/index.blade.php ENDPATH**/ ?>