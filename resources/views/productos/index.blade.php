@extends('layouts.app')
@section('titulo', 'Productos')

@section('contenido')

    {{-- Título e introducción --}}
    <h1 class="mb-2">CATÁLOGO DE PRODUCTOS</h1>
    <div class="row align-items-start">

        {{-- COLUMNA IZQUIERDA: GRID DE PRODUCTOS --}}
        <div class="col-lg-9 col-md-8">
            <div id="products" class="row g-4">

                @forelse($productos as $producto)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card h-100 d-flex flex-column">

                            {{-- Imagen principal del producto --}}
                            <img
                                src="{{ $producto->pro_imagen
                                        ? asset(ltrim($producto->pro_imagen, '/'))
                                        : asset('images/no-image.png') }}"
                                alt="{{ $producto->pro_descripcion }}"
                                class="card-img-top">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $producto->pro_descripcion }}</h5>

                                <a href="#"
                                   class="btn btn-primary mt-auto">
                                    Ver Detalle
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning mb-0">
                            No hay productos para mostrar.
                        </div>
                    </div>
                @endforelse

            </div>
        </div>

        {{-- COLUMNA DERECHA: TARJETA DEL CARRITO --}}
        <div class="col-lg-3 col-md-4">
            <aside class="card sticky-cart">
                <div class="card-body">
                    <h5 class="card-title mb-3"><strong>Tu Carrito</strong></h5>

                    <div id="cart">
                        <p>Tu carrito está vacío.</p>
                    </div>

                    <hr>

                    <div id="resumen">
                        <p class="mb-1">
                            <strong>Subtotal (0 productos):</strong>
                        </p>
                        <p class="fs-5 text-success fw-bold">$0.00</p>
                        <button class="btn btn-warning w-100 fw-semibold mt-3" type="button">
                            Ver Carrito Completo
                        </button>
                    </div>
                </div>
            </aside>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $productos->links() }}
        </div>

    </div>
@endsection
