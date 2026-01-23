<?php $__env->startSection('titulo', 'Registrarse - ColdMarket'); ?>

<?php $__env->startSection('contenido'); ?>
    <div class="login-page-container">
        <div class="register-card-minimal">
            <!-- Header -->
            <div class="register-header-minimal">
                <h2>Crear Cuenta</h2>
                <p>Completa todos los campos para registrarte</p>
            </div>

            <!-- Mensajes de Error General -->
            <?php if($errors->has('register_error')): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?php echo e($errors->first('register_error')); ?>

                </div>
            <?php endif; ?>

            <!-- Formulario de Registro -->
            <form action="<?php echo e(route('auth.register')); ?>" method="POST" id="registerForm">
                <?php echo csrf_field(); ?>

                <!-- Nombre Completo -->
                <div class="form-group-center">
                    <label for="cli_nombre">Nombre Completo <span class="required-minimal">*</span></label>
                    <div class="input-with-icon">
                        <i class="bi bi-person"></i>
                        <input type="text" class="form-control-center <?php $__errorArgs = ['cli_nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="cli_nombre" name="cli_nombre" placeholder="Tu nombre completo"
                            value="<?php echo e(old('cli_nombre')); ?>" maxlength="40" autocomplete="name" required>
                    </div>
                    <?php $__errorArgs = ['cli_nombre'];
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
                            id="cli_ruc_ced" name="cli_ruc_ced" placeholder="10 o 13 dígitos"
                            value="<?php echo e(old('cli_ruc_ced', session('pre_cedula', ''))); ?>" pattern="[0-9]{10}|[0-9]{13}"
                            maxlength="13" autocomplete="off" required>
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
                            id="cli_mail" name="cli_mail" placeholder="tu@email.com"
                            value="<?php echo e(old('cli_mail', session('pre_email', ''))); ?>" maxlength="60" autocomplete="email"
                            required>
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

                <!-- Teléfono y Celular -->
                <div class="row g-2">
                    <div class="col-12 col-sm-6">
                        <div class="form-group-center">
                            <label for="cli_telefono">Teléfono</label>
                            <div class="input-with-icon">
                                <i class="bi bi-telephone"></i>
                                <input type="text" class="form-control-center <?php $__errorArgs = ['cli_telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="cli_telefono" name="cli_telefono" placeholder="Número de teléfono"
                                    value="<?php echo e(old('cli_telefono')); ?>" pattern="0[2-3][0-9]{7}" maxlength="9"
                                    autocomplete="tel">
                            </div>
                            <span class="form-text-minimal">Ej: 022345678</span>
                            <?php $__errorArgs = ['cli_telefono'];
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
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="form-group-center">
                            <label for="cli_celular">Celular <span class="required-minimal">*</span></label>
                            <div class="input-with-icon">
                                <i class="bi bi-phone"></i>
                                <input type="text" class="form-control-center <?php $__errorArgs = ['cli_celular'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="cli_celular" name="cli_celular" placeholder="Número de celular"
                                    value="<?php echo e(old('cli_celular')); ?>" pattern="09[0-9]{8}" maxlength="10" autocomplete="tel"
                                    required>
                            </div>
                            <span class="form-text-minimal">Ej: 0991234567</span>
                            <?php $__errorArgs = ['cli_celular'];
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
                    </div>
                </div>

                <!-- Dirección -->
                <div class="form-group-center">
                    <label for="cli_direccion">Dirección <span class="required-minimal">*</span></label>
                    <div class="input-with-icon">
                        <i class="bi bi-geo-alt"></i>
                        <input type="text" class="form-control-center <?php $__errorArgs = ['cli_direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="cli_direccion" name="cli_direccion" placeholder="Tu dirección de residencia"
                            value="<?php echo e(old('cli_direccion')); ?>" maxlength="60" autocomplete="street-address" required>
                    </div>
                    <?php $__errorArgs = ['cli_direccion'];
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

                <!-- Contraseña y Confirmar Contraseña -->
                <div class="row g-2">
                    <div class="col-12 col-sm-6">
                        <div class="form-group-center">
                            <label for="password">Contraseña <span class="required-minimal">*</span></label>
                            <div class="input-with-icon">
                                <i class="bi bi-lock"></i>
                                <input type="password" class="form-control-center <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="password" name="password" placeholder="••••••••••" minlength="10"
                                    autocomplete="new-password" required>
                                <button type="button" class="toggle-password-center" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error-message"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <ul class="password-requirements-minimal">
                                <li id="req-length"><i class="bi bi-x-circle uncheck"></i> Mínimo 10 caracteres</li>
                                <li id="req-uppercase"><i class="bi bi-x-circle uncheck"></i> Mínimo una mayúscula</li>
                                <li id="req-number"><i class="bi bi-x-circle uncheck"></i> Mínimo un número</li>
                                <li id="req-special"><i class="bi bi-x-circle uncheck"></i> Mínimo un carácter especial
                                    (@$!%*?&)
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="form-group-center">
                            <label for="password_confirmation">Confirmar Contraseña <span
                                    class="required-minimal">*</span></label>
                            <div class="input-with-icon">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" class="form-control-center" id="password_confirmation"
                                    name="password_confirmation" placeholder="••••••••••" minlength="10" required>
                                <button type="button" class="toggle-password-center" id="togglePasswordConfirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <span class="form-text-minimal" id="password-match-text"></span>
                        </div>
                    </div>
                </div>

                <!-- Botón Registrarse -->
                <button type="submit" class="btn-register-minimal w-100" id="btnSubmit">
                    <i class="bi bi-person-check me-2"></i> Registrarse
                </button>
            </form>

            <!-- Footer del registro -->
            <div class="register-footer-minimal">
                <p>¿Ya tienes cuenta? <a href="<?php echo e(route('auth.login')); ?>">Iniciar sesión</a></p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle Password Visibility - Contraseña
            const togglePasswordBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function () {
                    const icon = this.querySelector('i');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            }

            // Toggle Password Visibility - Confirmar Contraseña
            const togglePasswordConfBtn = document.getElementById('togglePasswordConfirmation');
            const passwordConfInput = document.getElementById('password_confirmation');

            if (togglePasswordConfBtn && passwordConfInput) {
                togglePasswordConfBtn.addEventListener('click', function () {
                    const icon = this.querySelector('i');

                    if (passwordConfInput.type === 'password') {
                        passwordConfInput.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        passwordConfInput.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            }

            // Validación en tiempo real de contraseña
            const passwordInputVal = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            const matchText = document.getElementById('password-match-text');

            if (passwordInputVal) {
                passwordInputVal.addEventListener('input', function () {
                    const password = this.value;

                    // Validar longitud
                    updateRequirement('req-length', password.length >= 10);

                    // Validar mayúscula
                    updateRequirement('req-uppercase', /[A-Z]/.test(password));

                    // Validar número
                    updateRequirement('req-number', /[0-9]/.test(password));

                    // Validar carácter especial
                    updateRequirement('req-special', /[@$!%*?&]/.test(password));

                    // Verificar coincidencia
                    if (passwordConfirmation) checkPasswordMatch();
                });
            }

            if (passwordConfirmation) {
                passwordConfirmation.addEventListener('input', checkPasswordMatch);
            }

            function updateRequirement(id, isValid) {
                const element = document.getElementById(id);
                if (!element) return;

                const icon = element.querySelector('i');
                if (!icon) return;

                if (isValid) {
                    icon.className = 'bi bi-check-circle check';
                } else {
                    icon.className = 'bi bi-x-circle uncheck';
                }
            }

            function checkPasswordMatch() {
                if (!passwordInputVal || !passwordConfirmation || !matchText) return;

                const password = passwordInputVal.value;
                const confirmation = passwordConfirmation.value;

                if (confirmation.length === 0) {
                    matchText.textContent = '';
                    passwordConfirmation.classList.remove('is-valid', 'is-invalid');
                    return;
                }

                if (password === confirmation) {
                    matchText.textContent = '✓ Las contraseñas coinciden';
                    matchText.style.color = '#059669';
                    passwordConfirmation.classList.remove('is-invalid');
                    passwordConfirmation.classList.add('is-valid');
                } else {
                    matchText.textContent = '✗ Las contraseñas no coinciden';
                    matchText.style.color = '#DC2626';
                    passwordConfirmation.classList.remove('is-valid');
                    passwordConfirmation.classList.add('is-invalid');
                }
            }

            // Validación de solo números para cédula/RUC
            const cedulaInput = document.getElementById('cli_ruc_ced');
            if (cedulaInput) {
                cedulaInput.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            // Validación de solo números para teléfono
            const telefonoInput = document.getElementById('cli_telefono');
            if (telefonoInput) {
                telefonoInput.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            // Validación de solo números para celular
            const celularInput = document.getElementById('cli_celular');
            if (celularInput) {
                celularInput.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            // UX FIX MEDIO #8: Prevenir doble submit en registro
            const registerForm = document.getElementById('registerForm');
            const btnSubmit = document.getElementById('btnSubmit');

            if (registerForm && btnSubmit) {
                registerForm.addEventListener('submit', function (e) {
                    if (btnSubmit.disabled) {
                        e.preventDefault();
                        return false;
                    }

                    btnSubmit.disabled = true;
                    btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Registrando...';
                });
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Documents\Martin Herrera\UNIVERSIDAD\CARRERA INGENIERIA EN SISTEMAS DE LA INFORMACIÓN\QUINTO SEMESTRE\Desarrollo_Basado_Plat_HERD\proyecto_integrador_ecommerce\resources\views/auth/register.blade.php ENDPATH**/ ?>