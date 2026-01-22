@extends('admin.layouts.app')
@section('titulo', 'Nuevo Cliente')
@section('contenido')
    <h1>Registrar Cliente</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.clientes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            {{-- FIFTH AUDIT FIX #5 & #6: Autocomplete y placeholder --}}
            <label class="form-label">Identificador *</label>
            <input type="text" name="id_cliente" class="form-control" maxlength="7" placeholder="Máx 7 caracteres"
                autocomplete="off" required>
        </div>

        <div class="mb-3">
            {{-- FIFTH AUDIT FIX #5 & #6: Autocomplete y placeholder --}}
            <label class="form-label">Nombre Cliente *</label>
            <input type="text" name="cli_nombre" class="form-control" maxlength="40"
                placeholder="Nombre completo del cliente" autocomplete="name" required>
        </div>


        <div class="mb-3">
            {{-- FIFTH AUDIT FIX #5 & #6: Autocomplete y placeholder --}}
            <label class="form-label">Cedula/RUC *</label>
            <input type="text" name="cli_ruc_ced" class="form-control" maxlength="13" placeholder="10 o 13 dígitos"
                autocomplete="off" required>
        </div>

        <div class="mb-3">
            {{-- FIFTH AUDIT FIX #5 & #6: Autocomplete y placeholder --}}
            <label class="form-label">Telefono *</label>
            <input type="tel" name="cli_telefono" class="form-control" maxlength="10" placeholder="Ej: 022345678"
                autocomplete="tel" required>
        </div>

        <div class="mb-3">
            {{-- FIFTH AUDIT FIX #3: Ya corregido arriba --}}
            <label class="form-label">Mail *</label>
            <input type="email" name="cli_mail" class="form-control" maxlength="60" placeholder="email@ejemplo.com"
                autocomplete="email" required>
        </div>

        <div class="mb-3">
            {{-- FIFTH AUDIT FIX #5 & #6: Autocomplete y placeholder --}}
            <label class="form-label">Número Celular *</label>
            <input type="tel" name="cli_celular" class="form-control" maxlength="10" placeholder="Ej: 0991234567"
                autocomplete="tel" required>
        </div>

        <div class="mb-3">
            {{-- FIFTH AUDIT FIX #5 & #6: Autocomplete y placeholder --}}
            <label class="form-label">Dirección *</label>
            <input type="text" name="cli_direccion" class="form-control" maxlength="60"
                placeholder="Dirección completa del cliente" autocomplete="street-address" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ciudad *</label>
            <select name="id_ciudad" class="form-select" required>
                <option value="AMB">Ambato</option>
                <option value="CUE">Cuenca</option>
                <option value="GYE">Guayaquil</option>
                <option value='UIO'>Quito</option>
            </select>
        </div>

        <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection