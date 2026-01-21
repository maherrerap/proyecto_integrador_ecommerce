<?php $__env->startSection('contenido'); ?>
    <?php
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
    ?>
    
    <div class="producto-detalle-container">
        <div class="producto-detalle-back">
            <a href="<?php echo e(url()->previous()); ?>">&larr; Volver al Catálogo</a>
        </div>

        <div class="producto-detalle-grid">
            
            <div class="producto-imagen-section">
                <div class="producto-imagen-wrapper">
                    <img
                        id="imagenPrincipal"
                        src="<?php echo e($producto->pro_imagen ? asset(ltrim($producto->pro_imagen,'/')) : asset('images/no-image.png')); ?>"
                        class="producto-imagen-principal"
                        alt="<?php echo e($producto->pro_descripcion); ?>"
                    >
                </div>
            </div>

            
            <div>
                <div id="alert-carrito"></div>
                <h1 class="producto-titulo"><?php echo e($producto->pro_descripcion); ?></h1>

                <div class="producto-precio">
                    $<?php echo e(number_format((float)$producto->pro_precio_venta, 2, '.', ',')); ?>

                </div>

                <div class="producto-stock-container">
                    <span class="badge-stock <?php echo e($stockClase); ?>"><?php echo e($stockBadge); ?></span>
                    <span class="texto-stock <?php echo e($stockClase); ?>">
                        Stock: <?php echo e($stockTexto); ?>

                    </span>
                </div>

                <div class="d-flex gap-3 mt-3">
                    <button id="btn-add-cart"
                            class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2"
                            data-producto="<?php echo e($producto->id_producto); ?>">
                        <i class="bi bi-cart-plus"></i> Añadir al carrito
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Herd\proyecto_integrador_ecommerce\resources\views/productos/show.blade.php ENDPATH**/ ?>