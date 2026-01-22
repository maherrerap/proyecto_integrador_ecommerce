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

    <div class="container py-4">
        {{-- Breadcrumb / Volver --}}
        <div class="mb-3">
            <a href="{{ route('producto.index') }}"
                class="text-decoration-none text-primary d-inline-flex align-items-center">
                <i class="bi bi-arrow-left me-2"></i>
                <span>Volver al Catálogo</span>
            </a>
        </div>

        {{-- Detalle del Producto - Tarjeta unificada --}}
        <div class="card shadow-sm mb-5">
            <div class="card-body p-4">
                <div class="row g-4">
                    {{-- Imagen del producto --}}
                    <div class="col-12 col-md-5">
                        <div class="producto-imagen-wrapper rounded overflow-hidden bg-light d-flex align-items-center justify-content-center"
                            style="height: 400px;">
                            <img id="imagenPrincipal"
                                src="{{ $producto->pro_imagen ? asset(ltrim($producto->pro_imagen, '/')) : asset('images/no-image.png') }}"
                                class="img-fluid" alt="{{ $producto->pro_descripcion }}"
                                style="max-height: 100%; object-fit: contain;">
                        </div>
                    </div>

                    {{-- Información del producto --}}
                    <div class="col-12 col-md-7">
                        <div id="alert-carrito"></div>

                        {{-- Categoría --}}
                        @if($producto->categoria)
                            <div class="mb-2">
                                <span class="badge bg-secondary">{{ $producto->categoria->cat_descripcion }}</span>
                            </div>
                        @endif

                        {{-- Título --}}
                        <h1 class="h2 fw-bold mb-3">{{ $producto->pro_descripcion }}</h1>

                        {{-- Precio --}}
                        <div class="mb-4">
                            <span class="h3 text-primary fw-bold">
                                ${{ number_format((float) $producto->pro_precio_venta, 2, '.', ',') }}
                            </span>
                        </div>

                        {{-- Stock --}}
                        <div class="mb-4 p-3 bg-light rounded">
                            <div class="d-flex align-items-center gap-2">
                                <span
                                    class="badge {{ $stockClase == 'stock-agotado' ? 'bg-danger' : ($stockClase == 'stock-bajo' ? 'bg-warning text-dark' : 'bg-success') }}">
                                    {{ $stockBadge }}
                                </span>
                                <span class="text-muted">
                                    Stock: {{ $stockTexto }}
                                </span>
                            </div>
                        </div>

                        {{-- Botón de añadir al carrito --}}
                        <div class="d-grid gap-2">
                            <button id="btn-add-cart"
                                class="btn btn-lg {{ $disabled ? 'btn-secondary' : 'btn-primary' }} d-flex align-items-center justify-content-center gap-2"
                                data-producto="{{ $producto->id_producto }}" {{ $disabled ? 'disabled' : '' }}>
                                <i class="bi bi-cart-plus fs-5"></i>
                                <span>{{ $disabled ? 'Producto Agotado' : 'Añadir al Carrito' }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección de Productos Relacionados --}}
        @if($productosRelacionados->count() > 0)
            <div class="mt-5">
                <div class="text-center mb-4">
                    <h2 class="h3 fw-bold">Productos Relacionados</h2>
                    <p class="text-muted">Otros productos de la categoría
                        <strong>{{ $producto->categoria->cat_descripcion ?? 'similar' }}</strong></p>
                </div>

                <div class="row g-3 g-md-4">
                    @foreach($productosRelacionados as $productoRelacionado)
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('producto.show', $productoRelacionado->id_producto) }}" class="text-decoration-none">
                                <div class="card h-100 shadow-sm producto-relacionado-card">
                                    <div class="position-relative bg-light" style="height: 200px;">
                                        @php
                                            $imagenPath = 'images/productos/' . $productoRelacionado->id_producto . '.jpg';
                                        @endphp
                                        @if(file_exists(public_path($imagenPath)))
                                            <img src="{{ asset($imagenPath) }}" alt="{{ $productoRelacionado->pro_descripcion }}"
                                                class="card-img-top p-3" style="height: 100%; object-fit: contain;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body text-center p-3">
                                        <h5 class="card-title small mb-2" style="min-height: 2.5rem; line-height: 1.25rem;">
                                            {{ Str::limit($productoRelacionado->pro_descripcion, 40) }}
                                        </h5>
                                        <p class="text-muted small mb-2">
                                            {{ $productoRelacionado->categoria->cat_descripcion ?? 'Producto' }}
                                        </p>
                                        <p class="text-primary fw-bold mb-0">
                                            ${{ number_format($productoRelacionado->pro_precio_venta, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <style>
        .producto-relacionado-card {
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
        }

        .producto-relacionado-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            border-color: #007bff;
        }

        .badge-stock {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
    </style>
@endsection