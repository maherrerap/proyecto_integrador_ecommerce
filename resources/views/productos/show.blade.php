@extends('layouts.app')

@section('contenido')
    @php
        // UX FIX MEDIO #4: Ajustar umbral a 5 unidades para mayor realismo
        $umbralBajo = 5;

        if ($stockActual <= 0) {
            $stockTexto = 'Agotado';
            $stockClase = 'stock-agotado';
            $stockBadge = 'Agotado';
            $disabled = true;
        } elseif ($stockActual <= $umbralBajo) {
            $stockTexto = "Últimas {$stockActual} unidades";
            $stockClase = 'stock-bajo';
            $stockBadge = 'Últimas unidades';
            $disabled = false;
        } else {
            $stockTexto = "{$stockActual} unidades disponibles";
            $stockClase = 'stock-ok';
            $stockBadge = 'Disponible';
            $disabled = false;
        }
    @endphp

    <div class="producto-detalle-container">
        <div class="producto-detalle-back">
            {{-- UX FIX BAJO #5: Usar ruta específica en lugar de previous() --}}
            <a href="{{ route('producto.index') }}">&larr; Volver al Catálogo</a>
        </div>

        <div class="producto-detalle-grid">
            {{-- Imagen principal --}}
            <div class="producto-imagen-section">
                <div class="producto-imagen-wrapper">
                    <img id="imagenPrincipal"
                        src="{{ $producto->pro_imagen ? asset(ltrim($producto->pro_imagen, '/')) : asset('images/no-image.png') }}"
                        class="producto-imagen-principal" alt="{{ $producto->pro_descripcion }}">
                </div>
            </div>

            {{-- Info --}}
            <div>
                <div id="alert-carrito"></div>
                <h1 class="producto-titulo">{{ $producto->pro_descripcion }}</h1>

                <div class="producto-precio">
                    ${{ number_format((float) $producto->pro_precio_venta, 2, '.', ',') }}
                </div>

                <div class="producto-stock-container">
                    <span class="badge-stock {{ $stockClase }}">{{ $stockBadge }}</span>
                    <span class="texto-stock {{ $stockClase }}">
                        Stock: {{ $stockTexto }}
                    </span>
                </div>

                <div class="d-flex gap-3 mt-3">
                    {{-- UX FIX #6: Deshabilitar botón cuando no hay stock --}}
                    <button id="btn-add-cart"
                        class="btn {{ $disabled ? 'btn-secondary' : 'btn-primary' }} d-flex align-items-center gap-2 px-4 py-2"
                        data-producto="{{ $producto->id_producto }}" {{ $disabled ? 'disabled' : '' }}>
                        <i class="bi bi-cart-plus"></i>
                        {{ $disabled ? 'Agotado' : 'Añadir al carrito' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección de Productos Relacionados --}}
    @if($productosRelacionados->count() > 0)
        <section class="featured-products-section" style="margin-top: 4rem;">
            <div class="container-fluid section-container">
                <h2 class="text-center section-title">Productos Relacionados</h2>
                <p class="text-center text-muted mb-4">Otros productos de la categoría
                    {{ $producto->categoria->cat_descripcion ?? 'similar' }}</p>

                <div class="row g-3 g-md-4">
                    @foreach($productosRelacionados as $productoRelacionado)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <a href="{{ route('producto.show', $productoRelacionado->id_producto) }}"
                                style="text-decoration: none; color: inherit;">
                                <div class="featured-product-card">
                                    <div class="featured-product-image">
                                        @php
                                            $imagenPath = 'images/productos/' . $productoRelacionado->id_producto . '.jpg';
                                        @endphp
                                        @if(file_exists(public_path($imagenPath)))
                                            <img src="{{ asset($imagenPath) }}" alt="{{ $productoRelacionado->pro_descripcion }}"
                                                class="featured-img">
                                        @else
                                            <div class="featured-product-placeholder">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body text-center featured-product-body">
                                        <h5 class="featured-product-title">
                                            {{ $productoRelacionado->pro_descripcion }}
                                        </h5>
                                        <p class="featured-product-category">
                                            {{ $productoRelacionado->categoria->cat_descripcion ?? 'Producto' }}
                                        </p>
                                        <p class="featured-product-price">
                                            ${{ number_format($productoRelacionado->pro_precio_venta, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection