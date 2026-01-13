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
                    value="{{ request('criterio') }}"
                    class="form-control buscador-productos"
                    placeholder="Buscar producto..."
                    aria-label="Buscar producto"
                >
                <button type="submit" class="search-btn" aria-label="Buscar">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <div class="mt-2 text-muted">
                Sugerencia: no es necesario llenar toda la palabra del producto a buscar, solo escriba la porción que recuerde....
            </div>

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
                    <a href="{{ route('portada.index') }}" class="back-home">
                        Volver al Inicio...
                    </a>

                    <div class="catalog-pager">
                        {{ $productos->appends(request()->query())->onEachSide(1)->links() }}
                    </div>

                    <div class="mini-note">
                        Mostrando: <strong>{{ $productos->count() }}</strong>
                        de <strong>{{ $productos->total() }}</strong> Productos<br>
                        Marca tus productos como preferidos en la casilla.
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- CONTENIDO --}}
    <div class="row align-items-start">

        {{-- PRODUCTOS --}}
        <div class="col-lg-9 col-md-8">
            <div class="row g-4">
                @forelse($productos as $producto)
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
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning mb-0">
                            No hay productos para mostrar.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- SIDEBAR CARRITO --}}
        <div class="col-lg-3 col-md-4">
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
});
</script>
@endsection
