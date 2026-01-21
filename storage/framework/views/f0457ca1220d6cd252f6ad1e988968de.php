<?php $__env->startSection('titulo', 'Carrito de Compras'); ?>

<?php $__env->startSection('contenido'); ?>
    <h1 class="catalog-title mb-3">
        <i class="bi bi-cart3"></i> CARRITO DE COMPRAS
    </h1>

    
    <?php if($items->count() == 0 && empty($criterio)): ?>
        <div class="carrito-vacio-container">
            <img src="<?php echo e(asset('images/carrito-vacio.png')); ?>" alt="Carrito vacío" class="img-fluid carrito-vacio-img">
            <a href="<?php echo e(route('producto.index')); ?>" class="btn btn-primary mt-3">
                <i class="bi bi-cart-plus"></i> Ir a comprar
            </a>
        </div>
    <?php else: ?>
        
        <div class="row">
            
            <div class="col-md-8">

                
                <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                    
                    <form method="GET" action="<?php echo e(route('carrito.index')); ?>" class="flex-grow-1" style="max-width: 500px;">
                        <div class="search-container catalog-search" role="search">
                            <input type="text" name="criterio" value="<?php echo e($criterio); ?>" class="form-control buscador-productos"
                                placeholder="Buscar producto en el carrito..." aria-label="Buscar producto en carrito">
                            <button type="submit" class="search-btn" aria-label="Buscar">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>

                    
                    <button id="btn-vaciar-carrito" class="btn btn-outline-danger" data-carrito="<?php echo e($idCarrito); ?>"
                        style="white-space: nowrap;">
                        <i class="bi bi-trash"></i> Vaciar carrito
                    </button>
                </div>

                
                <?php if(!empty($criterio)): ?>
                    <div class="mb-3">
                        <span class="text-muted">Buscando: <strong>"<?php echo e($criterio); ?>"</strong></span>
                        <a href="<?php echo e(route('carrito.index')); ?>" class="btn btn-sm btn-outline-secondary ms-2">
                            <i class="bi bi-x-circle"></i> Limpiar búsqueda
                        </a>
                    </div>
                <?php endif; ?>

                
                <?php if($items->count() == 0 && !empty($criterio)): ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        No se encontraron productos que coincidan con "<strong><?php echo e($criterio); ?></strong>" en tu carrito.
                        <a href="<?php echo e(route('carrito.index')); ?>" class="alert-link">Ver todos los productos</a>
                    </div>
                <?php else: ?>
                    
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="carrito-item">

                            <!-- IMAGEN -->
                            <div class="carrito-item-imagen-wrapper">
                                <img src="<?php echo e(asset(ltrim($item->pro_imagen, '/'))); ?>" alt="<?php echo e($item->pro_descripcion); ?>"
                                    class="carrito-item-imagen">
                            </div>

                            <!-- DETALLES DEL PRODUCTO -->
                            <div class="carrito-item-detalles">
                                <h6 class="carrito-item-titulo">
                                    <?php echo e($item->pro_descripcion); ?>

                                </h6>
                                <p class="carrito-item-precio">
                                    $<?php echo e(number_format($item->pxf_precio, 2)); ?>

                                </p>
                                <div class="carrito-item-controles">
                                    <button class="btn-minus" data-producto="<?php echo e($item->id_producto); ?>"
                                        data-carrito="<?php echo e($idCarrito); ?>">−</button>
                                    <span id="qty-<?php echo e($item->id_producto); ?>" class="carrito-item-cantidad">
                                        <?php echo e($item->pxf_cantidad); ?>

                                    </span>
                                    <button class="btn-plus" data-producto="<?php echo e($item->id_producto); ?>"
                                        data-carrito="<?php echo e($idCarrito); ?>">+</button>
                                </div>
                            </div>

                            <!-- BOTÓN ELIMINAR -->
                            <button class="btn-remove" data-producto="<?php echo e($item->id_producto); ?>" data-carrito="<?php echo e($idCarrito); ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <a href="<?php echo e(route('producto.index')); ?>" class="btn btn-primary mt-3">
                        <i class="bi bi-cart-plus"></i> Comprar más
                    </a>
                <?php endif; ?>
            </div>

            
            <div class="col-md-4">
                <div class="card shadow-sm carrito-totales-card">
                    <div class="card-body carrito-totales-body">
                        <h5 class="fw-semibold mb-3">Sub-Total</h5>
                        <p class="carrito-subtotal">
                            $<?php echo e(number_format($Carrito->fac_subtotal, 2)); ?>

                        </p>
                        <p class="text-muted carrito-iva">
                            I.V.A. (15%): $<?php echo e(number_format($Carrito->fac_iva, 2)); ?>

                        </p>
                        <hr class="carrito-totales-hr">
                        <h4 class="fw-bold carrito-total">
                            $<?php echo e(number_format($Carrito->fac_total, 2)); ?>

                        </h4>

                        <button id="btn-aprobar-carrito" class="btn btn-success w-100" data-carrito="<?php echo e($idCarrito); ?>">
                            Pagar con tarjeta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Herd\proyecto_integrador_ecommerce\resources\views/carrito/index.blade.php ENDPATH**/ ?>