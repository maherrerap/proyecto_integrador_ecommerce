@extends('layouts.app')
@section('titulo', 'Carrito de Compras')

@section('contenido')
    <h1 class="catalog-title mb-3">
        <i class="bi bi-cart3"></i> CARRITO DE COMPRAS
    </h1>

    {{-- IF: CARRITO VACÍO --}}
    @if($items->count() == 0 && empty($criterio))
        <div class="carrito-vacio-container">
            <img src="{{ asset('images/carrito-vacio.png') }}" alt="Carrito vacío" class="img-fluid carrito-vacio-img">
            <a href="{{ route('producto.index') }}" class="btn btn-primary mt-3">
                <i class="bi bi-cart-plus"></i> Ir a comprar
            </a>
        </div>
    @else
        {{-- ELSE: CARRITO CON PRODUCTOS O CON BÚSQUEDA --}}
        <div class="row">
            {{-- LISTA DE PRODUCTOS --}}
            <div class="col-md-8">

                {{-- BARRA DE BÚSQUEDA Y BOTÓN VACIAR EN LA MISMA LÍNEA --}}
                <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                    {{-- BARRA DE BÚSQUEDA --}}
                    <form method="GET" action="{{ route('carrito.index') }}" class="flex-grow-1" style="max-width: 500px;">
                        <div class="search-container catalog-search" role="search">
                            <input type="text" name="criterio" value="{{ $criterio }}" class="form-control buscador-productos"
                                placeholder="Buscar producto en el carrito..." aria-label="Buscar producto en carrito">
                            <button type="submit" class="search-btn" aria-label="Buscar">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>

                    {{-- UX FIX MEDIO #2: Ocultar botón vaciar cuando no hay items --}}
                    @if($items->count() > 0)
                        {{-- BOTÓN VACIAR CARRITO --}}
                        <button id="btn-vaciar-carrito" class="btn btn-outline-danger" data-carrito="{{ $idCarrito }}"
                            style="white-space: nowrap;">
                            <i class="bi bi-trash"></i> Vaciar carrito
                        </button>
                    @endif
                </div>

                {{-- MENSAJE DE BÚSQUEDA ACTIVA --}}
                @if(!empty($criterio))
                    <div class="mb-3">
                        <span class="text-muted">Buscando: <strong>"{{ $criterio }}"</strong></span>
                        <a href="{{ route('carrito.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                            <i class="bi bi-x-circle"></i> Limpiar búsqueda
                        </a>
                    </div>
                @endif

                {{-- MENSAJE SI NO HAY RESULTADOS DE BÚSQUEDA --}}
                @if($items->count() == 0 && !empty($criterio))
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        No se encontraron productos que coincidan con "<strong>{{ $criterio }}</strong>" en tu carrito.
                        <a href="{{ route('carrito.index') }}" class="alert-link">Ver todos los productos</a>
                    </div>
                @else
                    {{-- LISTA DE PRODUCTOS DEL CARRITO --}}
                @foreach($items as $item)
                    <div class="carrito-item">

                        <!-- IMAGEN -->
                        <div class="carrito-item-imagen-wrapper">
                            <img src="{{ asset(ltrim($item->pro_imagen, '/')) }}" alt="{{ $item->pro_descripcion }}"
                                class="carrito-item-imagen">
                        </div>

                        <!-- DETALLES DEL PRODUCTO -->
                        <div class="carrito-item-detalles">
                            <h6 class="carrito-item-titulo">
                                {{ $item->pro_descripcion }}
                            </h6>
                            <p class="carrito-item-precio">
                                ${{ number_format($item->pxf_precio, 2) }}
                                @if($item->unidad_medida)
                                    <span class="text-muted" style="font-size: 0.85rem;">/ {{ $item->unidad_medida }}</span>
                                @endif
                            </p>
                            
                            <!-- INFORMACIÓN DE STOCK Y UNIDAD -->
                            <div class="mb-2">
                                @if($item->unidad_medida)
                                    <small class="text-muted">
                                        <i class="bi bi-box-seam"></i> Unidad: <strong>{{ $item->unidad_medida }}</strong>
                                    </small>
                                    <span class="text-muted mx-1">•</span>
                                @endif
                                <small class="text-muted">
                                    <i class="bi bi-archive"></i> Stock disponible: 
                                    <strong class="{{ $item->pro_saldo_final <= 5 ? 'text-warning' : 'text-success' }}">
                                        {{ $item->pro_saldo_final }} {{ $item->unidad_medida ? strtolower($item->unidad_medida) : 'unidades' }}
                                    </strong>
                                </small>
                            </div>

                            <div class="carrito-item-controles">
                                <button class="btn-minus" data-producto="{{ $item->id_producto }}" data-carrito="{{ $idCarrito }}"
                                    aria-label="Reducir cantidad de {{ $item->pro_descripcion }}">−</button>
                                <input type="number" 
                                    id="qty-{{ $item->id_producto }}" 
                                    class="carrito-item-cantidad-input" 
                                    value="{{ $item->pxf_cantidad }}" 
                                    min="1" 
                                    max="{{ $item->pro_saldo_final }}"
                                    data-producto="{{ $item->id_producto }}" 
                                    data-carrito="{{ $idCarrito }}"
                                    aria-label="Cantidad de {{ $item->pro_descripcion }}">
                                <button class="btn-plus" data-producto="{{ $item->id_producto }}" data-carrito="{{ $idCarrito }}"
                                    aria-label="Aumentar cantidad de {{ $item->pro_descripcion }}">+</button>
                            </div>
                            <div class="stock-alert text-danger small mt-1 d-none" id="stock-alert-{{ $item->id_producto }}">
                                ⚠ Cantidad mayor al stock disponible. Por favor verifique sus cantidades.<br>Se le asigno automaticamente la cantidad máxima de stock.
                            </div>
                        </div>
                        {{-- FOURTH AUDIT FIX #3: Agregar aria-label a botón eliminar --}}
                        <button class="btn-remove" data-producto="{{ $item->id_producto }}" data-carrito="{{ $idCarrito }}"
                            aria-label="Eliminar {{ $item->pro_descripcion }} del carrito">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                @endforeach

                    {{-- COMPRAR MÁS --}}
                    <a href="{{ route('producto.index') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-cart-plus"></i> Comprar más
                    </a>
                @endif
            </div>

            {{-- TOTALES --}}
            <div class="col-md-4">
                <div class="card shadow-sm carrito-totales-card">
                    <div class="card-body carrito-totales-body">
                        <h5 class="fw-semibold mb-3">Sub-Total</h5>
                        <p class="carrito-subtotal">
                            ${{ number_format($Carrito->fac_subtotal, 2) }}
                        </p>
                        <p class="text-muted carrito-iva">
                            I.V.A. (15%): ${{ number_format($Carrito->fac_iva, 2) }}
                        </p>
                        <hr class="carrito-totales-hr">
                        <h4 class="fw-bold carrito-total">
                            ${{ number_format($Carrito->fac_total, 2) }}
                        </h4>

                        <button id="btn-aprobar-carrito" class="btn btn-success w-100" data-carrito="{{ $idCarrito }}">
                            Pagar con tarjeta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection