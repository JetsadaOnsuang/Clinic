

<?php $__env->startSection('title', $appointment->exists ? 'แก้ไขนัดหมาย' : 'เพิ่มนัดหมาย'); ?>
<?php $__env->startSection('heading', $appointment->exists ? 'แก้ไขนัดหมาย' : 'เพิ่มนัดหมาย'); ?>
<?php $__env->startSection('subheading', 'เลือกผู้ป่วย แพทย์ และเวลานัดหมาย'); ?>

<?php $__env->startSection('content'); ?>
<section class="card p-3 p-md-4">
    <?php if(auth()->user()->isAdmin() && ($patients->isEmpty() || $doctors->isEmpty())): ?>
        <div class="alert alert-warning mb-0">ต้องเพิ่มข้อมูลผู้ป่วยและแพทย์ก่อน จึงจะสร้างนัดหมายได้</div>
        <div class="d-flex gap-2 mt-3">
            <?php if($patients->isEmpty()): ?><a href="<?php echo e(route('patients.create')); ?>" class="btn btn-outline-primary">เพิ่มผู้ป่วย</a><?php endif; ?>
            <?php if($doctors->isEmpty()): ?><a href="<?php echo e(route('doctors.create')); ?>" class="btn btn-outline-primary">เพิ่มแพทย์</a><?php endif; ?>
        </div>
    <?php else: ?>
    <form method="POST" action="<?php echo e($appointment->exists ? route('appointments.update', $appointment) : route('appointments.store')); ?>">
        <?php echo csrf_field(); ?>
        <?php if($appointment->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div class="row g-3">
            <?php if(auth()->user()->isAdmin()): ?>
                <div class="col-md-6"><label class="form-label" for="patient_id">ผู้ป่วย</label><select id="patient_id" name="patient_id" class="form-select <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><option value="">เลือกผู้ป่วย</option><?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($patient->id); ?>" <?php if((string) old('patient_id', $appointment->patient_id) === (string) $patient->id): echo 'selected'; endif; ?>><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?> (<?php echo e($patient->id_card); ?>)</option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                <div class="col-md-6"><label class="form-label" for="doctor_id">แพทย์</label><select id="doctor_id" name="doctor_id" class="form-select <?php $__errorArgs = ['doctor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><option value="">เลือกแพทย์</option><?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($doctor->id); ?>" <?php if((string) old('doctor_id', $appointment->doctor_id) === (string) $doctor->id): echo 'selected'; endif; ?>>นพ. <?php echo e($doctor->first_name); ?> <?php echo e($doctor->last_name); ?> — <?php echo e($doctor->specialty); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['doctor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                <div class="col-md-6"><label class="form-label" for="appointment_date">วันและเวลานัดหมาย</label><input id="appointment_date" name="appointment_date" type="datetime-local" value="<?php echo e(old('appointment_date', $appointment->appointment_date?->format('Y-m-d\TH:i'))); ?>" class="form-control <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                <div class="col-md-6"><label class="form-label" for="status">สถานะ</label><select id="status" name="status" class="form-select" required><?php $__currentLoopData = ['Pending' => 'รอตรวจ', 'Completed' => 'ตรวจแล้ว', 'Cancelled' => 'ยกเลิก']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('status', $appointment->status) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <?php else: ?>
                <div class="col-md-6"><label class="form-label">ผู้ป่วย</label><div class="form-control bg-light"><?php echo e($appointment->patient->first_name); ?> <?php echo e($appointment->patient->last_name); ?> · <?php echo e($appointment->patient->id_card); ?></div></div>
                <div class="col-md-6"><label class="form-label">วันและเวลา</label><div class="form-control bg-light"><?php echo e($appointment->appointment_date->format('d/m/Y H:i')); ?></div></div>
                <input type="hidden" name="patient_id" value="<?php echo e($appointment->patient_id); ?>">
                <input type="hidden" name="doctor_id" value="<?php echo e($appointment->doctor_id); ?>">
                <input type="hidden" name="appointment_date" value="<?php echo e($appointment->appointment_date->format('Y-m-d\TH:i')); ?>">
                <div class="col-md-6"><label class="form-label" for="status">สถานะการตรวจ</label><select id="status" name="status" class="form-select" required><?php $__currentLoopData = ['Pending' => 'รอตรวจ', 'Completed' => 'ตรวจแล้ว']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('status', $appointment->status) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <?php endif; ?>
            <div class="col-12"><label class="form-label" for="symptoms">อาการเบื้องต้น / บันทึกการตรวจ</label><textarea id="symptoms" name="symptoms" rows="3" class="form-control <?php $__errorArgs = ['symptoms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php echo e(old('symptoms', $appointment->symptoms)); ?></textarea><?php $__errorArgs = ['symptoms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
            <div class="col-12"><label class="form-label" for="diagnosis">ผลการวินิจฉัย</label><textarea id="diagnosis" name="diagnosis" rows="3" class="form-control"><?php echo e(old('diagnosis', $appointment->diagnosis)); ?></textarea></div>
        </div>
        <div class="d-flex gap-2 mt-4"><button class="btn btn-primary"><?php echo e(auth()->user()->isDoctor() ? 'บันทึกข้อมูลการตรวจ' : 'บันทึกนัดหมาย'); ?></button><a href="<?php echo e(route('appointments.index')); ?>" class="btn btn-outline-secondary">ยกเลิก</a></div>
    </form>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\EDB project\6714421008\resources\views/appointments/form.blade.php ENDPATH**/ ?>