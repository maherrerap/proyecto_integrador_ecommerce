@extends('admin.layouts.app')
@section('titulo', 'Clientes')
@section('contenido')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-3">
        <h1 class="mb-0">Clientes</h1>
        <a href="{{route('admin.clientes.create')}}" class="btn btn-primary">Nuevo Cliente</a>
    </div>
    <p>Administra los Clientes Activos de la Sucursal de QUITO</p>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Identificador</th>
                <th>Nombre</th>
                <th>Cédula / RUC</th>
                <th>Telefono</th>
                <th>Mail</th>
                <th>Número Celular</th>
                <th>Dirección Domicilio</th>
                <th>Estado</th>
                <th>Ciudad</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{$cliente->id_cliente}}</td>
                    <td>{{$cliente->cli_nombre}}</td>
                    <td>{{$cliente->cli_ruc_ced}}</td>
                    <td>{{$cliente->cli_telefono}}</td>
                    <td>{{$cliente->cli_mail}}</td>
                    <td>{{$cliente->cli_celular}}</td>
                    <td>{{$cliente->cli_direccion}}</td>
                    <td>{{$cliente->estado_cli}}</td>
                    <td>{{$cliente->id_ciudad}}</td>
                    <td>
                        <a href="{{route('admin.clientes.edit', $cliente)}}" class="btn btn-sm btn-warning">Editar</a>
                        <form action = "{{route('admin.clientes.destroy', $cliente->id_cliente)}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Inhabilitar Cliente?')">Inhabilitar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="catalog-pager">
            {{ $clientes->onEachSide(1)->links() }}
        </div>
    </div>
@endsection
