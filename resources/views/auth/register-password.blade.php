@extends('layouts.app')
@section('titulo', 'Crear Contraseña - ColdMarket')

@section('contenido')
    <div class="login-page-container">
        <div class="register-card-minimal">
            <!-- Header -->
            <div class="register-header-minimal">
                <h2>Bienvenido, {{ $cliente->cli_nombre }}</h2>
                <p>Crea una contraseña para tu cuenta web</p>
            </div>

            <!-- Mensajes de Error General -->
            @if($errors->has('register_error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ $errors->first('register_error') }}
                </div>
            @endif

            <!-- Información del Cliente -->
            <div class="alert alert-info mb-4">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-info-circle" style="font-size: 1.5rem;"></i>
                    <div>
                        <strong>Cuenta encontrada</strong>
                        <p style="margin: 5px 0 0 0; font-size: 0.9rem;">
                            {{ $cliente->cli_mail }} - Cédula/RUC: {{ $cliente->cli_ruc_ced }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Formulario de Contraseña -->
            <form action="{{ route('auth.registerPassword') }}" method="POST" id="passwordForm">
                @csrf

                <!-- Campos ocultos -->
                <input type="hidden" name="id_cliente" value="{{ $cliente->id_cliente }}">
                <input type="hidden" name="cli_mail" value="{{ $cliente->cli_mail }}">

                <!-- Contraseña -->
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
                        <li id="req-special"><i class="bi bi-x-circle uncheck"></i> Mínimo un carácter especial (@$!%*?&)
                        </li>
                    </ul>
                </div>

                <!-- Confirmar Contraseña -->
                <div class="form-group-center">
                    <label for="password_confirmation">Confirmar Contraseña <span class="required-minimal">*</span></label>
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

                <!-- Botón Crear Cuenta -->
                <button type="submit" class="btn-register-minimal" id="btnSubmit">
                    <i class="bi bi-check-circle me-2"></i> Crear Cuenta Web
                </button>
            </form>

            <!-- Footer -->
            <div class="register-footer-minimal">
                <p>¿No eres {{ $cliente->cli_nombre }}? <a href="{{ route('auth.showRegisterVerify') }}">Volver</a></p>
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
        });
    </script>
@endpush