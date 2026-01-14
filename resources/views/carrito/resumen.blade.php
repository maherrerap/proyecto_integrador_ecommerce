<h5 class="card-title mb-3"><strong>Tu Carrito</strong></h5>

@if($items->count() == 0)
    <p class="mb-2">Tu carrito está vacío.</p>
    <hr>
    <p class="mb-1"><strong>Subtotal (0 productos):</strong></p>
    <p class="fs-5 text-success fw-bold mb-0">$0.00</p>
@else
    <div class="cart-mini-list">
        @foreach($items as $item)
            @php
                $img = $item->pro_imagen
                    ? asset(ltrim($item->pro_imagen, '/'))
                    : asset('images/no-image.png');
            @endphp

            <div class="cart-mini-item">
                <img class="cart-mini-img" src="{{ $img }}" alt="{{ $item->pro_descripcion }}">
                <div class="cart-mini-info">
                    <div class="cart-mini-name">{{ $item->pro_descripcion }}</div>
                    <div class="cart-mini-qty">Cantidad: <strong>{{ $item->pxf_cantidad }}</strong></div>
                </div>
            </div>
        @endforeach
    </div>

    <hr>

    <p class="mb-1">
        <strong>Subtotal ({{ $totalUnidades }} productos):</strong>
    </p>
    <p class="fs-5 text-success fw-bold mb-0">
        ${{ number_format((float)($Carrito->fac_subtotal ?? 0), 2) }}
    </p>
@endif

<a href="{{ route('carrito.index') }}" class="btn btn-warning w-100 fw-semibold mt-3">
    Ver Carrito Completo
</a>
