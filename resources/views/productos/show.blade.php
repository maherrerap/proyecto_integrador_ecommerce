@extends('layouts.app')

@section('contenido')
    @php
        $imagenes = array_fill(0,5, $producto -> pro_imagen);
        $umbralBajo = 20;

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
    <div style="max-width: 1100px; margin: 0 auto; padding: 24px;">
        <div style="margin-bottom: 14px;">
            <a href="{{ url()->previous() }}" style="text-decoration:none;">&larr; Volver al Catálogo</a>
        </div>

        <div style="display:grid; grid-template-columns: 560px 1fr; gap: 48px;">
        {{-- Imagen principal --}}
            <div style="display:flex; gap:24px; align-items:flex-start;">
            <!-- Miniaturas -->
                <div style="display:flex; flex-direction:column; gap:12px; width:96px">
                    @foreach($imagenes as $img)
                        <img
                            src="{{ $img ? asset(ltrim($img,'/')) : asset('images/no-image.png') }}"
                            style="width:80px; height:80px; object-fit:contain; border:1px solid #e5e7eb; border-radius:10px; cursor:pointer; background:#fff;"
                            onclick="cambiarImagen('{{ asset(ltrim($img,'/')) }}')"
                        >
                    @endforeach
                </div>

                <!-- Imagen principal -->
                <div style="flex:1; background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:24px;">
                <img
                        id="imagenPrincipal"
                        src="{{ $producto->pro_imagen ? asset(ltrim($producto->pro_imagen,'/')) : asset('images/no-image.png') }}"
                        style="width:100%; max-width:480px; height:520px; object-fit:contain; margin:auto;"
                >
                </div>
            </div>

            {{-- Info --}}
            <div>
                <h1 style="font-size:28px; margin:0 0 8px;">{{ $producto->pro_descripcion }}</h1>

                <div style="font-size:22px; font-weight:700; margin:0 0 14px;">
                    ${{ number_format((float)$producto->pro_precio_venta, 2, '.', ',') }}
                </div>

                <div style="display:flex; align-items:center; gap:10px; margin:12px 0 18px;">
                    <span class="badge-stock {{ $stockClase }}">{{ $stockBadge }}</span>
                    <span class="texto-stock {{ $stockClase }}">
                        Stock: {{ $stockTexto }}
                    </span>
                </div>

                <div class="d-flex gap-3 mt-3">
                    <button
                        type="button"
                        class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2"
                        {{ $disabled ? 'disabled' : '' }}
                        title="{{ $disabled ? 'Producto sin stock' : 'Añadir al carrito' }}"
                    >
                        🛒 <span>Añadir al carrito</span>
                    </button>

                    <button
                        type="button"
                        class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2"
                        {{ $disabled ? 'disabled' : '' }}
                        title="{{ $disabled ? 'Producto sin stock' : 'Comprar ahora' }}"
                    >
                        🧾 <span>Comprar ahora</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .badge-stock{
            font-size: 12px;
            font-weight: 700;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid transparent;
        }

        .texto-stock{
            font-size: 13px;
            font-weight: 600;
        }

        .stock-ok{
            color: #0f7a3a;
        }
        .badge-stock.stock-ok{
            background: #e9f8ef;
            border-color: #bce9cb;
        }

        .stock-bajo{
            color: #9a6b00;
        }
        .badge-stock.stock-bajo{
            background: #fff6dd;
            border-color: #ffe2a3;
        }

        .stock-agotado{
            color: #b42318;
        }
        .badge-stock.stock-agotado{
            background: #ffebe9;
            border-color: #ffc7c2;
        }

        .btn-accion{
            padding: 10px 16px;
            border-radius: 10px;
            border: 0;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-accion:disabled{
            cursor: not-allowed;
            opacity: 0.55;
            filter: grayscale(35%);
        }
    </style>

    <script>
        function cambiarImagen(src) {
            document.getElementById('imagenPrincipal').src =src;
        }
    </script>
@endsection
