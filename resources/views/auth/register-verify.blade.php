@extends('layouts.app')
@section('titulo', 'Verificar Cuenta - ColdMarket')

@section('contenido')
    <div class="login-page-container">
        <div class="register-card-minimal">
            <!-- Header -->
            <div class="register-header-minimal">
                <h2>Verificar Datos</h2>
                <p>Ingrese su correo y cédula para continuar</p>
            </div>

            <!-- Mensajes de Error General -->
            @if($errors->has('verify_error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ $errors->first('verify_error') }}
                </div>
            @endif

            <!-- Formulario de Verificación -->
            <form action="{{ route('auth.verifyClient') }}" method="POST" id="verifyForm">
                @csrf

                <!-- Correo Electrónico -->
                <div class="form-group-center">
                    <label for="cli_mail">Correo Electrónico <span class="required-minimal">*</span></label>
                    <div class="input-with-icon">
                        <i class="bi bi-envelope"></i>
                        <input type="email" class="form-control-center @error('cli_mail') is-invalid @enderror"
                            id="cli_mail" name="cli_mail" placeholder="ejemplo@correo.com"
                            value="{{ old('cli_mail', session('pre_email', '')) }}" maxlength="60" required>
                    </div>
                    @error('cli_mail')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Cédula/RUC -->
                <div class="form-group-center">
                    <label for="cli_ruc_ced">Cédula o RUC <span class="required-minimal">*</span></label>
                    <div class="input-with-icon">
                        <i class="bi bi-card-text"></i>
                        <input type="text" class="form-control-center @error('cli_ruc_ced') is-invalid @enderror"
                            id="cli_ruc_ced" name="cli_ruc_ced" placeholder="1234567890 o 1234567890001"
                            value="{{ old('cli_ruc_ced', session('pre_cedula', '')) }}" pattern="[0-9]{10}|[0-9]{13}"
                            maxlength="13" required>
                    </div>
                    <span class="form-text-minimal">Ingrese 10 dígitos para cédula o 13 para RUC</span>
                    @error('cli_ruc_ced')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Botón Verificar -->
                <button type="submit" class="btn-register-minimal">
                    <i class="bi bi-search me-2"></i> Verificar Datos
                </button>
            </form>

            <!-- Footer -->
            <div class="register-footer-minimal">
                <p>¿Ya tienes cuenta? <a href="{{ route('auth.login') }}">Iniciar sesión</a></p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
@endpush