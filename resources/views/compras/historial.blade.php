@extends('layouts.app')

@section('contenido')
<div class="container py-4">

    {{-- Título estilo carrito --}}
    <div class="historial-header">
        <h1 class="catalog-title mb-4">
            Historial de Compras
        </h1>
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
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Haz clic en cualquier compra</strong> para ver el detalle de los productos.
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha de pago</th>
                                        <th class="text-end">Sub-Total</th>
                                        <th class="text-end">IVA</th>
                                        <th class="text-end">Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($compras as $c)
                                    <tr class="cursor-pointer compra-row" data-carrito="{{ $c->id_carrito }}" style="cursor: pointer;">
                                        <td>
                                            <div>
                                                <strong>{{ $c->fac_fecha_pago ? \Carbon\Carbon::parse($c->fac_fecha_pago)->format('d/m/Y') : '—' }}</strong>
                                            </div>
                                            <small class="text-muted">{{ $c->fac_fecha_pago ? \Carbon\Carbon::parse($c->fac_fecha_pago)->format('H:i') : '' }}</small>
                                        </td>
                                        <td class="text-end">${{ number_format((float)$c->fac_subtotal, 2) }}</td>
                                        <td class="text-end">${{ number_format((float)$c->fac_iva, 2) }}</td>
                                        <td class="text-end"><b>${{ number_format((float)$c->fac_total, 2) }}</b></td>
                                        <td class="text-end">
                                            <i class="bi bi-chevron-right text-muted"></i>
                                        </td>
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
                <div class="card-body historial-resumen-card">
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

            {{-- Botón ir al carrito debajo del resumen --}}
            <div class="mt-3">
                <a href="{{ route('carrito.index') }}" class="btn btn-dark w-100">
                    <i class="bi bi-cart3 me-2"></i>Ir al carrito
                </a>
            </div>
        </div>
    </div>

</div>

{{-- Modal para mostrar detalle de la compra --}}
<div class="modal fade" id="detalleCompraModal" tabindex="-1" aria-labelledby="detalleCompraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalleCompraModalLabel">
                    <i class="bi bi-receipt"></i> Detalle de Compra
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-detalle-content">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2 text-muted">Cargando detalle...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
.compra-row:hover {
    background-color: #f8f9fa;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('detalleCompraModal'));
    const modalContent = document.getElementById('modal-detalle-content');

    // Agregar evento click a cada fila
    document.querySelectorAll('.compra-row').forEach(row => {
        row.addEventListener('click', function() {
            const idCarrito = this.dataset.carrito;
            cargarDetalleCompra(idCarrito);
        });
    });

    function cargarDetalleCompra(idCarrito) {
        // Mostrar modal con loading
        modalContent.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="mt-2 text-muted">Cargando detalle...</p>
            </div>
        `;
        modal.show();

        // Hacer petición AJAX
        fetch(`/historial-compras/${idCarrito}/detalle`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.ok) {
                mostrarDetalle(data);
            } else {
                modalContent.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        ${data.message || 'Error al cargar el detalle'}
                    </div>
                `;
            }
        })
        .catch(error => {
            modalContent.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    Error de conexión al cargar el detalle
                </div>
            `;
        });
    }

    function mostrarDetalle(data) {
        const fechaPago = data.carrito.fecha_pago 
            ? new Date(data.carrito.fecha_pago).toLocaleString('es-EC', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
              })
            : '—';

        let html = `
            <div class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>ID Carrito:</strong> ${data.carrito.id}</p>
                        <p class="mb-1"><strong>Fecha de pago:</strong> ${fechaPago}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>Subtotal:</strong> $${parseFloat(data.carrito.subtotal).toFixed(2)}</p>
                        <p class="mb-1"><strong>IVA (15%):</strong> $${parseFloat(data.carrito.iva).toFixed(2)}</p>
                        <p class="mb-1"><strong class="text-primary fs-5">Total: $${parseFloat(data.carrito.total).toFixed(2)}</strong></p>
                    </div>
                </div>
            </div>

            <hr>

            <h6 class="mb-3"><i class="bi bi-box-seam"></i> Productos Comprados</h6>

            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio Unit.</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        data.productos.forEach(producto => {
            html += `
                <tr>
                    <td>${producto.pro_descripcion}</td>
                    <td class="text-center">${producto.pxf_cantidad}</td>
                    <td class="text-end">$${parseFloat(producto.pxf_precio).toFixed(2)}</td>
                    <td class="text-end">$${parseFloat(producto.pxf_subtotal).toFixed(2)}</td>
                </tr>
            `;
        });

        html += `
                    </tbody>
                </table>
            </div>
        `;

        modalContent.innerHTML = html;
    }
});
</script>
@endsection