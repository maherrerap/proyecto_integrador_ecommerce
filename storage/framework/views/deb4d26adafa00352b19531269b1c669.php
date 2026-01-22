<?php $__env->startSection('titulo', 'Verificar Cuenta - ColdMarket'); ?>

<?php $__env->startSection('contenido'); ?>
    <div class="login-page-container">
        <div class="register-card-minimal">
            <!-- Header -->
            <div class="register-header-minimal">
                <h2>Verificar Datos</h2>
                <p>Ingrese su correo y cédula para continuar</p>
            </div>

            <!-- Mensajes de Error General -->
            <?php if($errors->has('verify_error')): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?php echo e($errors->first('verify_error')); ?>

                </div>
            <?php endif; ?>

            <!-- Formulario de Verificación -->
            <form action="<?php echo e(route('auth.verifyClient')); ?>" method="POST" id="verifyForm">
                <?php echo csrf_field(); ?>

                <!-- Correo Electrónico -->
                <div class="form-group-center">
                    <label for="cli_mail">Correo Electrónico <span class="required-minimal">*</span></label>
                    <div class="input-with-icon">
                        <i class="bi bi-envelope"></i>
                        <input type="email" class="form-control-center <?php $__errorArgs = ['cli_mail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="cli_mail" name="cli_mail" placeholder="ejemplo@correo.com"
                            value="<?php echo e(old('cli_mail', session('pre_email', ''))); ?>" maxlength="60" required>
                    </div>
                    <?php $__errorArgs = ['cli_mail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error-message"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Cédula/RUC -->
                <div class="form-group-center">
                    <label for="cli_ruc_ced">Cédula o RUC <span class="required-minimal">*</span></label>
                    <div class="input-with-icon">
                        <i class="bi bi-card-text"></i>
                        <input type="text" class="form-control-center <?php $__errorArgs = ['cli_ruc_ced'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="cli_ruc_ced" name="cli_ruc_ced" placeholder="1234567890 o 1234567890001"
                            value="<?php echo e(old('cli_ruc_ced', session('pre_cedula', ''))); ?>" pattern="[0-9]{10}|[0-9]{13}"
                            maxlength="13" required>
                    </div>
                    <span class="form-text-minimal">Ingrese 10 dígitos para cédula o 13 para RUC</span>
                    <?php $__errorArgs = ['cli_ruc_ced'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error-message"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Botón Verificar -->
                <button type="submit" class="btn-register-minimal">
                    <i class="bi bi-search me-2"></i> Verificar Datos
                </button>
            </form>

            <!-- Footer -->
            <div class="register-footer-minimal">
                <p>¿Ya tienes cuenta? <a href="<?php echo e(route('auth.login')); ?>">Iniciar sesión</a></p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Validación de solo números para cédula/RUC
            const cedulaInput = document.getElementById('cli_ruc_ced');
            if (cedulaInput) {
                cedulaInput.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Herd\proyecto_integrador_ecommerce\resources\views/auth/register-verify.blade.php ENDPATH**/ ?>