@extends('layouts.app')
@section('titulo', 'Iniciar Sesión - ColdMarket')

@section('contenido')
    <div class="login-split-container">
        <div class="login-split-wrapper">
            <!-- Lado IZQUIERDO: Imagen decorativa -->
            <div class="login-split-image">
                <img src="{{ asset('images/split_ColdMarket.png') }}" alt="ColdMarket Shopping">
            </div>

            <!-- Lado DERECHO: Formulario -->
            <div class="login-split-form">
                <div class="login-card-center">
                    <div class="login-header-center">
                        <h3>ColdMarket Login</h3>
                        <p class="login-value-prop">Compra tecnología, ropa y hogar en un solo lugar</p>
                    </div>

                    <!-- Mensajes de Error -->
                    @if($errors->has('login_error'))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            {{ $errors->first('login_error') }}
                        </div>
                    @endif

                    <!-- Mensaje de Éxito -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Mensaje de Advertencia -->
                    @if(session('warning'))
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ session('warning') }}
                        </div>
                    @endif

                    <!-- Formulario de Login -->
                    <form action="{{ route('auth.login') }}" method="POST" id="loginForm">
                        @csrf

                        <!-- Email/Usuario -->
                        <div class="form-group-center">
                            <label for="email">Usuario o correo</label>
                            <div class="input-with-icon">
                                <i class="bi bi-envelope input-icon-left"></i>
                                <input type="email" class="form-control-center @error('email') is-invalid @enderror" id="email"
                                    name="email" placeholder="Ingresa tu usuario o correo" value="{{ old('email') }}" required
                                    autocomplete="email">
                                <i class="bi bi-check-circle input-validation-icon" id="emailValidIcon"></i>
                            </div>
                            <span class="inline-error-message" id="emailError"></span>
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="form-group-center">
                            <label for="password">Contraseña</label>
                            <div class="input-with-icon">
                                <i class="bi bi-lock input-icon-left"></i>
                                <input type="password" class="form-control-center @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Ingresa la contraseña" required
                                    autocomplete="current-password">
                                <button type="button" class="toggle-password-center" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Botón Entrar -->
                        <button type="submit" class="btn-entrar">
                            Entrar
                        </button>
                    </form>

                    <!-- Link Olvidaste tu contraseña -->
                    <div class="login-footer-center">
                        <p><a href="#">¿Olvidaste tu contraseña?</a></p>
                    </div>

                    <!-- Link a Registro -->
                    <div class="login-footer-center">
                        <p>¿No tienes cuenta? <a href="{{ route('auth.showRegisterVerify') }}">Regístrate aquí</a></p>
                    </div>
                </div>

                <!-- Indicador de seguridad - FUERA del login-card-center -->
                <div class="security-badge">
                    <i class="bi bi-shield-check"></i> Conexión segura
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Script para mostrar/ocultar contraseña
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
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

        // Validación en tiempo real del email
        const emailInput = document.getElementById('email');
        const emailValidIcon = document.getElementById('emailValidIcon');
        const emailError = document.getElementById('emailError');

        emailInput.addEventListener('input', function () {
            const email = this.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email.length === 0) {
                // Campo vacío
                emailValidIcon.style.display = 'none';
                emailError.textContent = '';
                this.classList.remove('valid-input', 'invalid-input');
            } else if (emailRegex.test(email)) {
                // Email válido
                emailValidIcon.style.display = 'block';
                emailError.textContent = '';
                this.classList.remove('invalid-input');
                this.classList.add('valid-input');
            } else {
                // Email inválido
                emailValidIcon.style.display = 'none';
                emailError.textContent = 'Correo no válido';
                this.classList.remove('valid-input');
                this.classList.add('invalid-input');
            }
        });

        // Limpiar validación al cargar si hay old value
        if (emailInput.value.length > 0) {
            emailInput.dispatchEvent(new Event('input'));
        }
    </script>
@endpush