<?php $__env->startSection('titulo', 'Productos'); ?>

<?php $__env->startSection('contenido'); ?>
<div class="catalog-page">

    
    <div class="mb-3">
        <h1 class="catalog-title mb-3">CATÁLOGO DE PRODUCTOS</h1>

        
        <form method="GET" action="<?php echo e(route('producto.index')); ?>" id="filtrosForm">

            
            <div class="search-container catalog-search" role="search">
                <input
                    type="text"
                    name="criterio"
                    value="<?php echo e($criterio); ?>"
                    class="form-control buscador-productos"
                    placeholder="Buscar producto..."
                    aria-label="Buscar producto"
                >
                <button type="submit" class="search-btn" aria-label="Buscar">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            
            <?php if(!empty($criterio)): ?>
            <div class="mt-2 mb-2">
                <span class="text-muted">Buscando: <strong>"<?php echo e($criterio); ?>"</strong></span>
                <a href="<?php echo e(route('producto.index')); ?>" class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="bi bi-x-circle"></i> Limpiar búsqueda
                </a>
            </div>
            <?php else: ?>
            <?php endif; ?>

            
            <div class="mt-3 catalog-topbar">

                
                <div class="filters-row d-flex flex-wrap align-items-center gap-2 gap-md-3">

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <span class="me-2 text-nowrap">Categorías:</span>

                        <?php
                            $selectedCats = (array) request('categorias', []);
                        ?>

                        
                        <label class="filter-pill mb-0">
                            <input type="checkbox" id="chk_todos" <?php echo e(empty($selectedCats) ? 'checked' : ''); ?>>
                            <span>Todos</span>
                        </label>

                        
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="filter-pill mb-0">
                                <input
                                    type="checkbox"
                                    name="categorias[]"
                                    value="<?php echo e($cat->id_categoria); ?>"
                                    <?php echo e(in_array((string)$cat->id_categoria, array_map('strval', $selectedCats), true) ? 'checked' : ''); ?>

                                >
                                <span><?php echo e($cat->cat_descripcion); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
                <div class="catalog-right-top mt-2 mt-md-0">
                    
                    <a href="<?php echo e(route('portada.index')); ?>" class="back-home">
                        Volver al Inicio
                    </a>

                    <div class="catalog-pager">
                        <?php echo e($productos->appends(request()->query())->onEachSide(1)->links()); ?>

                    </div>


                    
                    <div class="mini-note">
                        Mostrando: <strong><?php echo e($productos->count()); ?></strong>
                        de <strong><?php echo e($productos->total()); ?></strong> Productos
                    </div>
                </div>

            </div>
        </form>
    </div>

    
    <div class="row align-items-start">

        
        <div class="col-12 col-lg-9">
            
            
            <?php if($productos->count() == 0 && !empty($criterio)): ?>
                <div class="alert alert-warning text-center">
                    <i class="bi bi-search" style="font-size: 2rem;"></i>
                    <h5 class="mt-2">No encontramos "<?php echo e($criterio); ?>"</h5>
                    <p class="mb-2">Intenta con otras palabras o explora nuestro catálogo completo</p>
                    <a href="<?php echo e(route('producto.index')); ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-grid"></i> Ver todos los productos
                    </a>
                </div>
            <?php elseif($productos->count() == 0): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    No hay productos disponibles en este momento.
                </div>
            <?php else: ?>
                <div class="row g-2 g-md-3 g-lg-4">
                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
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
                        ?>

                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <div class="card product-card h-100 position-relative">
                                <div class="tag-categoria"><?php echo e($categoria); ?></div>

                                <div class="product-img-wrap">
                                    <img src="<?php echo e($img); ?>" alt="<?php echo e($producto->pro_descripcion); ?>" class="product-img" loading="lazy">
                                </div>

                                <div class="card-body d-flex flex-column text-center">
                                    <div class="mb-2">
                                        <?php echo e($producto->pro_descripcion); ?>

                                    </div>

                                    <div class="price mb-3">
                                        $<?php echo e(number_format((float)($precio ?? 0), 2, ',', '.')); ?>

                                    </div>

                                    <a href="<?php echo e($showUrl); ?>"
                                       class="btn <?php echo e($agotado ? 'btn-secondary btn-agotado' : 'btn-primary'); ?> btn-detalle mt-auto">
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="col-12 col-lg-3 mt-4 mt-lg-0">
            <aside class="card cart-card sticky-cart">
                <div class="card-body" id="cart-summary">
                    <p class="mb-0 text-muted">Inicia sesión para ver carrito</p>
                </div>
            </aside>
        </div>
    </div>
</div>


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

  // Cuando se hace clic en "Todos"
  chkTodos.addEventListener('change', () => {
    if (chkTodos.checked) {
      catChecks.forEach(c => c.checked = false);
      form.submit();
    }
  });

  // CAMBIO PRINCIPAL: Al hacer clic en una categoría, desmarcar las demás
  catChecks.forEach(chk => {
    chk.addEventListener('change', function() {
      if (this.checked) {
        // Desmarcar todas las demás categorías excepto la actual
        catChecks.forEach(c => {
          if (c !== this) {
            c.checked = false;
          }
        });
      }
      
      syncTodos();
      form.submit();
    });
  });

  // Loading state en búsqueda/filtrado con timeout de seguridad
  form.addEventListener('submit', function() {
    const loadingOverlay = document.createElement('div');
    loadingOverlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;z-index:9999;';
    loadingOverlay.innerHTML = '<div class="spinner-border text-light" role="status"><span class="visually-hidden">Cargando...</span></div>';
    document.body.appendChild(loadingOverlay);
    
    setTimeout(() => {
      if (loadingOverlay.parentNode) {
        loadingOverlay.remove();
        console.warn('Loading overlay removido por timeout');
      }
    }, 10000);
  });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Documents\Martin Herrera\UNIVERSIDAD\CARRERA INGENIERIA EN SISTEMAS DE LA INFORMACIÓN\QUINTO SEMESTRE\Desarrollo_Basado_Plat_HERD\proyecto_integrador_ecommerce\resources\views/productos/index.blade.php ENDPATH**/ ?>