

<?php $__env->startSection('title', $doctor->exists ? 'แก้ไขแพทย์' : 'เพิ่มแพทย์'); ?>
<?php $__env->startSection('heading', $doctor->exists ? 'แก้ไขข้อมูลแพทย์' : 'เพิ่มแพทย์ใหม่'); ?>
<?php $__env->startSection('subheading', 'กรอกข้อมูลแพทย์ให้ครบถ้วน'); ?>

<?php $__env->startSection('content'); ?>
<section class="card p-3 p-md-4">
    <form method="POST" action="<?php echo e($doctor->exists ? route('doctors.update', $doctor) : route('doctors.store')); ?>">
        <?php echo csrf_field(); ?>
        <?php if($doctor->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="first_name">ชื่อ</label><input id="first_name" name="first_name" value="<?php echo e(old('first_name', $doctor->first_name)); ?>" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
            <div class="col-md-6"><label class="form-label" for="last_name">นามสกุล</label><input id="last_name" name="last_name" value="<?php echo e(old('last_name', $doctor->last_name)); ?>" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
            <div class="col-md-6"><label class="form-label" for="license_no">เลขที่ใบประกอบวิชาชีพ</label><input id="license_no" name="license_no" value="<?php echo e(old('license_no', $doctor->license_no)); ?>" maxlength="20" class="form-control <?php $__errorArgs = ['license_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php $__errorArgs = ['license_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
            <div class="col-md-6"><label class="form-label" for="specialty">ความเชี่ยวชาญ / แผนก</label><input id="specialty" name="specialty" value="<?php echo e(old('specialty', $doctor->specialty)); ?>" maxlength="100" class="form-control <?php $__errorArgs = ['specialty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php $__errorArgs = ['specialty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
            <div class="col-md-6"><label class="form-label" for="phone">เบอร์โทรศัพท์</label><input id="phone" name="phone" value="<?php echo e(old('phone', $doctor->phone)); ?>" maxlength="15" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
            <div class="col-md-6"><label class="form-label" for="email">อีเมล</label><input id="email" name="email" type="email" value="<?php echo e(old('email', $doctor->email)); ?>" maxlength="100" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
        </div>
        <div class="border-top mt-4 pt-4">
            <h2 class="section-title h6 mb-1">บัญชีเข้าสู่ระบบแพทย์</h2>
            <p class="text-secondary small">แพทย์จะใช้บัญชีนี้เพื่อดูนัดหมายและบันทึกข้อมูลเฉพาะผู้ป่วยที่ได้รับมอบหมาย</p>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="account_email">อีเมลสำหรับเข้าสู่ระบบ</label>
                    <input id="account_email" name="account_email" type="email" value="<?php echo e(old('account_email', $account?->email)); ?>" class="form-control <?php $__errorArgs = ['account_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" required>
                    <?php $__errorArgs = ['account_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="account_password"><?php echo e($account ? 'ตั้งรหัสผ่านใหม่ (เว้นว่างหากไม่เปลี่ยน)' : 'รหัสผ่านเริ่มต้น'); ?></label>
                    <input id="account_password" name="account_password" type="password" minlength="8" class="form-control <?php $__errorArgs = ['account_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="new-password" <?php echo e($account ? '' : 'required'); ?>>
                    <?php $__errorArgs = ['account_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-text">อย่างน้อย 8 ตัวอักษร</div>
                </div>
            </div>
            <?php if($account): ?>
                <div class="small text-success mt-2">บัญชีแพทย์เปิดใช้งานแล้ว: <?php echo e($account->email); ?></div>
            <?php else: ?>
                <div class="form-text mt-2">ระบบจะสร้างบัญชีแพทย์เมื่อกรอกอีเมลและรหัสผ่านครบ</div>
            <?php endif; ?>
        </div>
        <div class="d-flex gap-2 mt-4"><button class="btn btn-primary">บันทึกข้อมูล</button><a href="<?php echo e(route('doctors.index')); ?>" class="btn btn-outline-secondary">ยกเลิก</a></div>
    </form>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\EDB project\6714421008\resources\views/doctors/form.blade.php ENDPATH**/ ?>