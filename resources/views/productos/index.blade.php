@extends('layouts.app')
@section('titulo', 'Productos')

@section('contenido')
    <div class="catalog-page">

        {{-- TÍTULO --}}
        <div class="mb-3">
            <h1 class="catalog-title mb-3">CATÁLOGO DE PRODUCTOS</h1>

            {{-- BUSCADOR --}}
            <form method="GET" action="{{ route('producto.index') }}" class="search-container catalog-search" role="search">
                <input
                    type="text"
                    name="criterio"
                    value="{{ request('criterio') }}"
                    class="search-input"
                    placeholder="Buscar producto, categoría o marca..."
                    aria-label="Buscar producto"
                >
                <button type="submit" class="search-btn" aria-label="Buscar">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <div class="mt-2 text-muted" style="font-size:13px;">
                Sugerencia: usa palabras clave como ‘alimentos’, ‘ferretería’ o ‘ropa’ para mejores resultados.
            </div>

            {{-- FILTROS --}}
            <div class="mt-3 catalog-topbar">

                {{-- IZQUIERDA: CATEGORÍAS + FILTROS --}}
                <div class="filters-row d-flex flex-wrap align-items-center gap-3">

                    <div class="d-flex flex-wrap align-items-center">
                        <span class="me-2" style="font-size:13px;color:#495057;">Categorías Disponibles:</span>

                        @php
                            $cats = [
                                ['key'=>'Todos |  .','value'=>'ALL'],
                                ['key'=>'Alimentos | .','value'=>'ALI'],
                                ['key'=>'Ropa |  .','value'=>'RPA'],
                                ['key'=>'Ferretería |  .','value'=>'FRR'],
                                ['key'=>'Electrodomésticos','value'=>'ELE'],
                            ];
                            $selectedCats = (array) request('categorias', []);
                        @endphp

                        @foreach($cats as $c)
                            @php
                                $checked = $c['value']==='ALL'
                                    ? (empty($selectedCats) || in_array('ALL',$selectedCats))
                                    : in_array($c['value'],$selectedCats);
                            @endphp
                            <label class="filter-pill mb-0">
                                <input type="checkbox" name="categorias[]" value="{{ $c['value'] }}"
                                       {{ $checked ? 'checked' : '' }}
                                       onchange="this.form.submit()">
                                <span style="font-size:13px;">{{ $c['key'] }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="d-flex flex-wrap align-items-center">
                        <span class="me-2" style="font-size:13px;color:#495057;">Filtros Rápidos:</span>

                        @php $quick = request('filtro',''); @endphp

                        <label class="filter-pill mb-0">
                            <input type="radio" name="filtro" value="mas_vendidos"
                                   {{ $quick==='mas_vendidos' ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span style="font-size:13px;">Más Vendidos  |</span>
                        </label>

                        <label class="filter-pill mb-0">
                            <input type="radio" name="filtro" value="novedades"
                                   {{ $quick==='novedades' ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span style="font-size:13px;">Novedades  |</span>
                        </label>

                        <label class="filter-pill mb-0">
                            <input type="radio" name="filtro" value=""
                                   {{ $quick==='' ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span style="font-size:13px;">Todos</span>
                        </label>
                    </div>
                </div>

                {{-- DERECHA: NAVEGACIÓN --}}
                <div class="catalog-right-top">
                    <a href="{{ route('portada.index') }}" class="back-home">
                        Volver al Inicio...
                    </a>

                    <div class="catalog-pager">
                        {{ $productos->onEachSide(1)->links() }}
                    </div>

                    <div class="mini-note">
                        Mostrando: <strong>{{ $productos->count() }}</strong>
                        de <strong>{{ $productos->total() }}</strong> Productos<br>
                        Marca tus productos como preferidos en la casilla.
                    </div>
                </div>

            </div>
        </div>

        {{-- CONTENIDO --}}
        <div class="row align-items-start">

            {{-- PRODUCTOS TODO: CAMBIAR LO DE CATEGORIA DESDE LA TABLA DE CATEGORIAS--}}
            <div class="col-lg-9 col-md-8">
                <div class="row g-4">
                    @forelse($productos as $producto)
                        @php
                            $id = $producto->id_producto ?? $producto->id ?? null;
                            $categoria = $producto->categoria->cat_nombre
                                ?? $producto->cat_nombre
                                ?? $producto->pro_categoria
                                ?? 'Alimentos';
                            $precio = $producto->pro_precio_venta ?? null;
                            $stock = $producto->pro_saldo_final ?? 1;
                            $agotado = is_numeric($stock) && (int)$stock <= 0;
                            $img = $producto->pro_imagen
                                ? asset(ltrim($producto->pro_imagen, '/'))
                                : asset('images/no-image.png');
                            $showUrl = $id ? route('producto.show', $id) : '#';
                        @endphp

                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <div class="card product-card h-100 position-relative">
                                <div class="tag-categoria">{{ $categoria }}</div>

                                <div class="product-img-wrap">
                                    <img src="{{ $img }}" alt="{{ $producto->pro_descripcion }}" class="product-img">
                                </div>

                                <div class="card-body d-flex flex-column text-center">
                                    <div class="mb-2" style="font-size:18px;font-weight:700;color:#495057;">
                                        {{ $producto->pro_descripcion }}
                                    </div>

                                    <div class="price mb-3">
                                        ${{ number_format((float)($precio ?? 0), 2, ',', '.') }}
                                    </div>

                                    <a href="{{ $showUrl }}"
                                       class="btn {{ $agotado ? 'btn-secondary' : 'btn-primary' }} btn-detalle mt-auto"
                                        {{ $agotado ? 'style=pointer-events:none;opacity:.85;' : '' }}>
                                        Ver Detalles
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

            {{-- SIDEBAR SOLO CARRITO --}}
            <div class="col-lg-3 col-md-4">
                <aside class="card cart-card sticky-cart">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><strong>Tu Carrito</strong></h5>

                        <p class="mb-2">Tu carrito está vacío.</p>
                        <hr>

                        <p class="mb-1"><strong>Subtotal (0 productos):</strong></p>
                        <p class="fs-5 text-success fw-bold mb-0">$0.00</p>

                        <button class="btn btn-warning w-100 fw-semibold mt-3">
                            Ver Carrito Completo
                        </button>
                    </div>
                </aside>
            </div>

        </div>
    </div>
@endsection
