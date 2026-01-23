@extends('layouts.app')

@section('contenido')
<div class="container py-4">

    {{-- Título estilo carrito --}}
    <div class="historial-header">
        <div class="historial-header-line"></div>
        <h1 class="historial-title">
            Historial de Compras
        </h1>
    </div>

    {{-- Buscador + botón --}}
    <div class="d-flex flex-column flex-lg-row gap-3 align-items-stretch align-items-lg-center mb-3">
        <form class="flex-grow-1" method="GET" action="{{ route('compras.historial') }}">
            <div class="input-group">
                <input type="text" class="form-control"
                       name="criterio"
                       placeholder="Buscar por ID de carrito o total..."
                       value="{{ $criterio }}">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                @if(!empty($criterio))
                    <a class="btn btn-outline-danger" href="{{ route('compras.historial') }}">Limpiar</a>
                @endif
            </div>
        </form>

        <a href="{{ route('carrito.index') }}" class="btn btn-dark">
            Ir al carrito
        </a>
    </div>

    <div class="row g-4">
        {{-- Listado --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if($compras->count() === 0)
                        <div class="historial-vacio">
                            <h5 class="mb-2">Aún no tienes compras registradas.</h5>
                            <p class="historial-vacio-text">Cuando pagues un carrito, aparecerá aquí con estado <b>PAG</b>.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>ID Carrito</th>
                                        <th class="text-end">Sub-Total</th>
                                        <th class="text-end">IVA</th>
                                        <th>Fecha de pago</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($compras as $c)
                                    <tr>
                                        <td><b>{{ $c->id_carrito }}</b></td>
                                        <td class="text-end">${{ number_format((float)$c->fac_subtotal, 2) }}</td>
                                        <td class="text-end">${{ number_format((float)$c->fac_iva, 2) }}</td>
                                        <td>
                                            {{ $c->fac_fecha_pago ? \Carbon\Carbon::parse($c->fac_fecha_pago)->format('d/m/Y H:i') : '—' }}
                                        </td>
                                        <td class="text-end"><b>${{ number_format((float)$c->fac_total, 2) }}</b></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $compras->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Resumen (estilo tarjeta derecha como tu carrito) --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3"><b>Resumen</b></h4>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Compras pagadas</span>
                        <b>{{ $totalCompras }}</b>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Total gastado</span>
                        <h4 class="m-0"><b>${{ number_format((float)$totalGastado, 2) }}</b></h4>
                    </div>

                    <div class="historial-note">
                        Aquí se muestran únicamente carritos con estado <b>PAG</b>.
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection