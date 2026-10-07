

<?php $__env->startSection('title', 'แพทย์'); ?>
<?php $__env->startSection('heading', 'จัดการข้อมูลแพทย์'); ?>
<?php $__env->startSection('subheading', 'ทะเบียนแพทย์และข้อมูลติดต่อ'); ?>

<?php $__env->startSection('content'); ?>
<section class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <form method="GET" class="d-flex gap-2">
            <input name="q" value="<?php echo e($search); ?>" class="form-control" placeholder="ชื่อ ความเชี่ยวชาญ หรือเลขใบอนุญาต" aria-label="ค้นหาแพทย์">
            <button class="btn btn-outline-primary">ค้นหา</button>
            <?php if($search !== ''): ?><a href="<?php echo e(route('doctors.index')); ?>" class="btn btn-outline-secondary">ล้าง</a><?php endif; ?>
        </form>
        <a href="<?php echo e(route('doctors.create')); ?>" class="btn btn-primary">+ เพิ่มแพทย์</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-3">
            <thead><tr><th>ชื่อ - นามสกุล</th><th>เลขใบอนุญาต</th><th>ความเชี่ยวชาญ</th><th>ชื่อบัญชี / อีเมลเข้าสู่ระบบ</th><th>เบอร์โทรศัพท์</th><th class="text-end">จัดการ</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="fw-semibold">นพ. <?php echo e($doctor->first_name); ?> <?php echo e($doctor->last_name); ?></td>
                    <td><?php echo e($doctor->license_no); ?></td><td><?php echo e($doctor->specialty); ?></td><td><span class="d-block"><?php echo e($doctor->user?->name ?? 'ยังไม่มีบัญชี'); ?></span><span class="small text-secondary"><?php echo e($doctor->user?->email ?? 'ยังไม่มีบัญชี'); ?></span></td><td><?php echo e($doctor->phone); ?></td>
                    <td class="text-end text-nowrap">
                        <a href="<?php echo e(route('doctors.edit', $doctor)); ?>" class="btn btn-sm btn-outline-primary">แก้ไข</a>
                        <form action="<?php echo e(route('doctors.destroy', $doctor)); ?>" method="POST" class="d-inline" onsubmit="return confirm('การลบแพทย์จะลบนัดหมายที่เกี่ยวข้องด้วย ยืนยันหรือไม่?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger">ลบ</button></form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-secondary py-4">ไม่พบข้อมูลแพทย์</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($doctors->links()); ?>

</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\EDB project\6714421008\resources\views/doctors/index.blade.php ENDPATH**/ ?>