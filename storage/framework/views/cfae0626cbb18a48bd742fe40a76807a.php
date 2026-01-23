<h5 class="card-title mb-3"><strong>Tu Carrito</strong></h5>

<?php if($items->count() == 0): ?>
    
    <p class="mb-2">Tu carrito está vacío.</p>
    <a href="<?php echo e(route('producto.index')); ?>" class="btn btn-sm btn-outline-primary">
        <i class="bi bi-shop"></i> Explorar productos
    </a>
    <hr>
    <p class="mb-1"><strong>Subtotal (0 productos):</strong></p>
    <p class="fs-5 text-success fw-bold mb-0">$0.00</p>
<?php else: ?>
    <div class="cart-mini-list">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $img = $item->pro_imagen
                    ? asset(ltrim($item->pro_imagen, '/'))
                    : asset('images/no-image.png');
            ?>

            <div class="cart-mini-item">
                <img class="cart-mini-img" src="<?php echo e($img); ?>" alt="<?php echo e($item->pro_descripcion); ?>">
                <div class="cart-mini-info">
                    <div class="cart-mini-name"><?php echo e($item->pro_descripcion); ?></div>
                    <div class="cart-mini-qty">Cantidad: <strong><?php echo e($item->pxf_cantidad); ?></strong></div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <hr>

    
    <p class="mb-1">
        <strong>Subtotal (<?php echo e($totalUnidades); ?> <?php echo e($totalUnidades == 1 ? 'producto' : 'productos'); ?>):</strong>
    </p>
    <p class="fs-5 text-success fw-bold mb-0">
        $<?php echo e(number_format((float) ($Carrito->fac_subtotal ?? 0), 2)); ?>

    </p>
<?php endif; ?>

<a href="<?php echo e(route('carrito.index')); ?>" class="btn btn-warning w-100 fw-semibold mt-3">
    Ver Carrito Completo
</a><?php /**PATH F:\Documents\Martin Herrera\UNIVERSIDAD\CARRERA INGENIERIA EN SISTEMAS DE LA INFORMACIÓN\QUINTO SEMESTRE\Desarrollo_Basado_Plat_HERD\proyecto_integrador_ecommerce\resources\views/carrito/resumen.blade.php ENDPATH**/ ?>