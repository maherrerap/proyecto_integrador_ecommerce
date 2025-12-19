@extends('layouts.app')
@section('titulo','Editar Cliente')
@section('contenido')
    <h1>Editar Cliente</h1>

    <form action="{{ route('admin.clientes.update', $cliente) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre Cliente *</label>
            <input type="text"
                   name="cli_nombre"
                   class="form-control"
                   maxlength="40"
                   value="{{ old('cli_nombre', $cliente->cli_nombre) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cedula/RUC *</label>
            <input type="text"
                   name="cli_ruc_ced"
                   class="form-control"
                   maxlength="13"
                   value="{{ old('cli_ruc_ced', $cliente->cli_ruc_ced) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Telefono Cliente *</label>
            <input type="text"
                   name="cli_telefono"
                   class="form-control"
                   maxlength="60"
                   value="{{ old('cli_telefono', $cliente->cli_telefono) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mail Cliente *</label>
            <input type="text"
                   name="cli_mail"
                   class="form-control"
                   maxlength="60"
                   value="{{ old('cli_mail', $cliente->cli_mail) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Celular Cliente *</label>
            <input type="text"
                   name="cli_celular"
                   class="form-control"
                   maxlength="10"
                   value="{{ old('cli_celular', $cliente->cli_celular) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección Cliente *</label>
            <input type="text"
                   name="cli_direccion"
                   class="form-control"
                   maxlength="10"
                   value="{{ old('cli_direccion', $cliente->cli_direccion) }}"
                   required>
        </div>

        <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
@endsection
