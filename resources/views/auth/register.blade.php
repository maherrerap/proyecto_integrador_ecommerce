@extends('layouts.app')
@section('titulo', 'Registrarse - ColdMarket')

@section('contenido')
    <div class="login-page-container">
        <div class="register-card-minimal">
            <!-- Header -->
            <div class="register-header-minimal">
                <h2>Crear Cuenta</h2>
                <p>Completa todos los campos para registrarte</p>
            </div>

            <!-- Mensajes de Error General -->
            @if($errors->has('register_error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ $errors->first('register_error') }}
                </div>
            @endif

            <!-- Formulario de Registro -->
            <form action="{{ route('auth.register') }}" method="POST" id="registerForm">
                @csrf

                <!-- Nombre Completo -->
                <div class="form-group-center">
                    <label for="cli_nombre">Nombre Completo <span class="required-minimal">*</span></label>
                    <div class="input-with-icon">
                        <i class="bi bi-person"></i>
                        <input type="text" class="form-control-center @error('cli_nombre') is-invalid @enderror"
                            id="cli_nombre" name="cli_nombre" placeholder="Tu nombre completo" value="{{ old('cli_nombre') }}"
                            maxlength="40" required>
                    </div>
                    @error('cli_nombre')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Cédula/RUC -->
                <div class="form-group-center">
                    <label for="cli_ruc_ced">Cédula o RUC <span class="required-minimal">*</span></label>
                    <div class="input-with-icon">
                        <i class="bi bi-card-text"></i>
                        <input type="text" class="form-control-center @error('cli_ruc_ced') is-invalid @enderror"
                            id="cli_ruc_ced" name="cli_ruc_ced" placeholder="10 o 13 dígitos"
                            value="{{ old('cli_ruc_ced', session('pre_cedula', '')) }}" pattern="[0-9]{10}|[0-9]{13}"
                            maxlength="13" required>
                    </div>
                    <span class="form-text-minimal">Ingrese 10 dígitos para cédula o 13 para RUC</span>
                    @error('cli_ruc_ced')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Correo Electrónico -->
                <div class="form-group-center">
                    <label for="cli_mail">Correo Electrónico <span class="required-minimal">*</span></label>
                    <div class="input-with-icon">
                        <i class="bi bi-envelope"></i>
                        <input type="email" class="form-control-center @error('cli_mail') is-invalid @enderror"
                            id="cli_mail" name="cli_mail" placeholder="tu@email.com"
                            value="{{ old('cli_mail', session('pre_email', '')) }}" maxlength="60" required>
                    </div>
                    @error('cli_mail')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Teléfono y Celular -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-center">
                            <label for="cli_telefono">Teléfono</label>
                            <div class="input-with-icon">
                                <i class="bi bi-telephone"></i>
                                <input type="text" class="form-control-center @error('cli_telefono') is-invalid @enderror"
                                    id="cli_telefono" name="cli_telefono" placeholder="Número de teléfono"
                                    value="{{ old('cli_telefono') }}" pattern="0[2-3][0-9]{7}" maxlength="9">
                            </div>
                            <span class="form-text-minimal">Ej: 022345678</span>
                            @error('cli_telefono')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group-center">
                            <label for="cli_celular">Celular <span class="required-minimal">*</span></label>
                            <div class="input-with-icon">
                                <i class="bi bi-phone"></i>
                                <input type="text" class="form-control-center @error('cli_celular') is-invalid @enderror"
                                    id="cli_celular" name="cli_celular" placeholder="Número de celular"
                                    value="{{ old('cli_celular') }}" pattern="09[0-9]{8}" maxlength="10" required>
                            </div>
                            <span class="form-text-minimal">Ej: 0991234567</span>
                            @error('cli_celular')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Dirección -->
                <div class="form-group-center">
                    <label for="cli_direccion">Dirección <span class="required-minimal">*</span></label>
                    <div class="input-with-icon">
                        <i class="bi bi-geo-alt"></i>
                        <input type="text" class="form-control-center @error('cli_direccion') is-invalid @enderror"
                            id="cli_direccion" name="cli_direccion" placeholder="Tu dirección de residencia"
                            value="{{ old('cli_direccion') }}" maxlength="60" required>
                    </div>
                    @error('cli_direccion')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Contraseña y Confirmar Contraseña -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-center">
                            <label for="password">Contraseña <span class="required-minimal">*</span></label>
                            <div class="input-with-icon">
                                <i class="bi bi-lock"></i>
                                <input type="password" class="form-control-center @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="••••••••••" minlength="10" required>
                                <button type="button" class="toggle-password-center" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
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

                    <div class="col-md-6">
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
                <button type="submit" class="btn-register-minimal" id="btnSubmit">
                    <i class="bi bi-person-check me-2"></i> Registrarse
                </button>
            </form>

            <!-- Footer del registro -->
            <div class="register-footer-minimal">
                <p>¿Ya tienes cuenta? <a href="{{ route('auth.login') }}">Iniciar sesión</a></p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
@endpush