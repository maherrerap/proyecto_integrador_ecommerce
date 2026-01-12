@extends('layouts.app')
@section('titulo', 'Carrito de Compras')

@section('contenido')
<h3 class="fw-semibold mb-4">
    <i class="bi bi-cart3"></i> Carrito de Compras
</h3>

{{-- IF: CARRITO VACÍO --}}
@if($items->count() == 0)
    <div class="d-flex flex-column align-items-center justify-content-center text-center" style="min-height: 75vh;">
        <img src="{{ asset('images/carrito-vacio.png') }}"
             alt="Carrito vacío"
             class="img-fluid carrito-vacio-img">
        <a href="{{ route('producto.index') }}"
           class="btn btn-primary mt-3">
            <i class="bi bi-cart-plus"></i> Ir a comprar
        </a>
    </div>
@else
{{-- ELSE: CARRITO CON PRODUCTOS --}}
<div class="row">
    {{-- LISTA DE PRODUCTOS --}}
    <div class="col-md-8">
        {{-- BOTÓN VACIAR CARRITO REPOSICIONADO --}}
        <div class="d-flex justify-content-end mb-3">
            <button id="btn-vaciar-carrito"
                    class="btn btn-outline-danger"
                    data-factura="{{ $idFactura }}">
                <i class="bi bi-trash"></i> Vaciar carrito
            </button>
        </div>

        @foreach($items as $item)
        <div style="display: flex !important; align-items: center !important; gap: 1.25rem !important; padding: 1.5rem !important; margin-bottom: 1.5rem !important; background: #ffffff !important; border: 2px solid #d1d5db !important; border-radius: 16px !important; box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important; position: relative !important;">
            
            <!-- IMAGEN -->
            <div style="flex-shrink: 0 !important; width: 120px !important; height: 120px !important; min-width: 120px !important; min-height: 120px !important; max-width: 120px !important; max-height: 120px !important; border-radius: 12px !important; overflow: hidden !important; background: #ffffff !important; display: flex !important; align-items: center !important; justify-content: center !important; border: 2px solid #e5e7eb !important; padding: 8px !important;">
                <img src="{{ asset(ltrim($item->pro_imagen, '/')) }}"
                    alt="{{ $item->pro_descripcion }}"
                    style="width: 100px !important; height: 100px !important; min-width: 100px !important; min-height: 100px !important; max-width: 100px !important; max-height: 100px !important; object-fit: contain !important; object-position: center !important; display: block !important;">
            </div>
            
            <!-- DETALLES DEL PRODUCTO -->
            <div style="flex-grow: 1 !important; min-width: 0 !important; display: flex !important; flex-direction: column !important; gap: 0.75rem !important;">
                <h6 style="margin: 0 !important; font-weight: 700 !important; font-size: 1.15rem !important; color: #111827 !important; line-height: 1.4 !important;">
                    {{ $item->pro_descripcion }}
                </h6>
                <p style="margin: 0 !important; font-size: 1.25rem !important; font-weight: 700 !important; color: #2563eb !important;">
                    ${{ number_format($item->pxf_precio, 2) }}
                </p>
                <div style="display: flex !important; align-items: center !important; gap: 0.5rem !important;">
                    <button class="btn-minus"
                            data-producto="{{ $item->id_producto }}"
                            data-factura="{{ $idFactura }}"
                            style="width: 36px !important; height: 36px !important; border: none !important; background: #e5e7eb !important; border-radius: 8px !important; font-size: 1.25rem !important; font-weight: 700 !important; cursor: pointer !important; display: flex !important; align-items: center !important; justify-content: center !important; padding: 0 !important; color: #374151 !important; line-height: 1 !important;">−</button>
                    <span id="qty-{{ $item->id_producto }}"
                          style="min-width: 40px !important; text-align: center !important; font-weight: 600 !important; font-size: 1.1rem !important; color: #111827 !important;">
                        {{ $item->pxf_cantidad }}
                    </span>
                    <button class="btn-plus"
                            data-producto="{{ $item->id_producto }}"
                            data-factura="{{ $idFactura }}"
                            style="width: 36px !important; height: 36px !important; border: none !important; background: #e5e7eb !important; border-radius: 8px !important; font-size: 1.25rem !important; font-weight: 700 !important; cursor: pointer !important; display: flex !important; align-items: center !important; justify-content: center !important; padding: 0 !important; color: #374151 !important; line-height: 1 !important;">+</button>
                </div>
            </div>
            
            <!-- BOTÓN ELIMINAR -->
            <button class="btn-remove"
                    data-producto="{{ $item->id_producto }}"
                    data-factura="{{ $idFactura }}"
                    style="position: absolute !important; top: 1.25rem !important; right: 1.25rem !important; width: 44px !important; height: 44px !important; border: none !important; background: #f3f4f6 !important; color: #6b7280 !important; border-radius: 10px !important; cursor: pointer !important; display: flex !important; align-items: center !important; justify-content: center !important; font-size: 1.25rem !important;">
                <i class="bi bi-trash"></i>
            </button>
        </div>
        @endforeach
        
        {{-- COMPRAR MÁS --}}
        <a href="{{ route('producto.index') }}"
           class="btn btn-primary mt-3">
            <i class="bi bi-cart-plus"></i> Comprar más
        </a>
    </div>
    
    {{-- TOTALES --}}
    <div class="col-md-4">
        <div class="card shadow-sm" style="max-height: 280px !important; height: fit-content !important;">
            <div class="card-body" style="padding: 1.5rem !important;">
                <h5 class="fw-semibold mb-3">Sub-Total</h5>
                <p class="mb-1" style="font-size: 1.1rem !important; font-weight: 600 !important;">
                    ${{ number_format($factura->fac_subtotal, 2) }}
                </p>
                <p class="text-muted mb-3" style="font-size: 0.9rem !important;">
                    I.V.A. (15%): ${{ number_format($factura->fac_iva, 2) }}
                </p>
                <hr style="margin: 1rem 0 !important;">
                <h4 class="fw-bold mb-3" style="font-size: 1.75rem !important; color: #111827 !important;">
                    ${{ number_format($factura->fac_total, 2) }}
                </h4>

                <button id="btn-aprobar-carrito"
                        class="btn btn-success w-100"
                        data-factura="{{ $idFactura }}">
                    Pagar con tarjeta
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection