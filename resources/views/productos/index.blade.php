@extends('layouts.app')
@section('titulo', 'Productos')

@section('contenido')
<div class="catalog-page">

    {{-- TÍTULO --}}
    <div class="mb-3">
        <h1 class="catalog-title mb-3">CATÁLOGO DE PRODUCTOS</h1>

        {{-- BUSCADOR + CATEGORÍAS (para que funcione el filtro) --}}
        <form method="GET" action="{{ route('producto.index') }}" id="filtrosForm">

            {{-- BUSCADOR --}}
            <div class="search-container catalog-search" role="search">
                <input
                    type="text"
                    name="criterio"
                    value="{{ $criterio }}"
                    class="form-control buscador-productos"
                    placeholder="Buscar producto..."
                    aria-label="Buscar producto"
                >
                <button type="submit" class="search-btn" aria-label="Buscar">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            {{-- MENSAJE DE BÚSQUEDA ACTIVA --}}
            @if(!empty($criterio))
            <div class="mt-2 mb-2">
                <span class="text-muted">Buscando: <strong>"{{ $criterio }}"</strong></span>
                <a href="{{ route('producto.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="bi bi-x-circle"></i> Limpiar búsqueda
                </a>
            </div>
            @else
            @endif

            {{-- TOPBAR: CATEGORÍAS + PAGINACIÓN --}}
            <div class="mt-3 catalog-topbar">

                {{-- IZQUIERDA: CATEGORÍAS --}}
                <div class="filters-row d-flex flex-wrap align-items-center gap-3">

                    <div class="d-flex flex-wrap align-items-center">
                        <span class="me-2">Categorías Disponibles:</span>

                        @php
                            $selectedCats = (array) request('categorias', []);
                        @endphp

                        {{-- TODOS --}}
                        <label class="filter-pill mb-0">
                            <input type="checkbox" id="chk_todos" {{ empty($selectedCats) ? 'checked' : '' }}>
                            <span>Todos</span>
                        </label>

                        {{-- CATEGORÍAS REALES DESDE BD --}}
                        @foreach($categorias as $cat)
                            <label class="filter-pill mb-0">
                                <input
                                    type="checkbox"
                                    name="categorias[]"
                                    value="{{ $cat->id_categoria }}"
                                    {{ in_array((string)$cat->id_categoria, array_map('strval', $selectedCats), true) ? 'checked' : '' }}
                                >
                                <span>{{ $cat->cat_descripcion }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- DERECHA: NAVEGACIÓN --}}
                <div class="catalog-right-top">
                    {{-- UX FIX BAJO #2: Simplificar texto sin puntos suspensivos --}}
                    <a href="{{ route('portada.index') }}" class="back-home">
                        Volver al Inicio
                    </a>

                    <div class="catalog-pager">
                        {{ $productos->appends(request()->query())->onEachSide(1)->links() }}
                    </div>


                    {{-- UX FIX MEDIO #6: Remover texto de favoritos sin funcionalidad --}}
                    <div class="mini-note">
                        Mostrando: <strong>{{ $productos->count() }}</strong>
                        de <strong>{{ $productos->total() }}</strong> Productos
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- CONTENIDO --}}
    <div class="row align-items-start">

        {{-- PRODUCTOS --}}
        <div class="col-lg-9 col-md-8">
            
            {{-- UX FIX MEDIO #1: Mensaje más empático y útil --}}
            @if($productos->count() == 0 && !empty($criterio))
                <div class="alert alert-warning text-center">
                    <i class="bi bi-search" style="font-size: 2rem;"></i>
                    <h5 class="mt-2">No encontramos "{{ $criterio }}"</h5>
                    <p class="mb-2">Intenta con otras palabras o explora nuestro catálogo completo</p>
                    <a href="{{ route('producto.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-grid"></i> Ver todos los productos
                    </a>
                </div>
            @elseif($productos->count() == 0)
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    No hay productos disponibles en este momento.
                </div>
            @else
                <div class="row g-4">
                    @foreach($productos as $producto)
                        @php
                            $id = $producto->id_producto ?? $producto->id ?? null;

                            $categoria = $producto->cat_descripcion
                                ?? $producto->pro_categoria
                                ?? 'Sin Categoría';

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
                                    <div class="mb-2">
                                        {{ $producto->pro_descripcion }}
                                    </div>

                                    <div class="price mb-3">
                                        ${{ number_format((float)($precio ?? 0), 2, ',', '.') }}
                                    </div>

                                    <a href="{{ $showUrl }}"
                                       class="btn {{ $agotado ? 'btn-secondary btn-agotado' : 'btn-primary' }} btn-detalle mt-auto">
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- SIDEBAR CARRITO --}}
        <div class="col-lg-3 col-md-4">
            <aside class="card cart-card sticky-cart">
                <div class="card-body" id="cart-summary">
                    <p class="mb-0 text-muted">Cargando carrito...</p>
                </div>
            </aside>
        </div>
    </div>
</div>

{{-- JS: autosubmit + lógica de "Todos" --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('filtrosForm');
  if (!form) return;

  const chkTodos = document.getElementById('chk_todos');
  const catChecks = form.querySelectorAll('input[name="categorias[]"]');

  function syncTodos() {
    const anyChecked = [...catChecks].some(c => c.checked);
    chkTodos.checked = !anyChecked; // si no hay ninguna marcada => "Todos"
  }

  syncTodos();

  chkTodos.addEventListener('change', () => {
    if (chkTodos.checked) {
      catChecks.forEach(c => c.checked = false);
      form.submit();
    }
  });

  catChecks.forEach(chk => {
    chk.addEventListener('change', () => {
      syncTodos();
      form.submit();
    });
  });

  // UX FIX #7: Loading state en búsqueda/filtrado
  form.addEventListener('submit', function() {
    const loadingOverlay = document.createElement('div');
    loadingOverlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;z-index:9999;';
    loadingOverlay.innerHTML = '<div class="spinner-border text-light" role="status"><span class="visually-hidden">Cargando...</span></div>';
    document.body.appendChild(loadingOverlay);
  });
});
</script>
@endsection