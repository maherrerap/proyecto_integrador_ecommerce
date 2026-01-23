<?php $__env->startSection('contenido'); ?>
    <?php
        // UX FIX MEDIO #4: Ajustar umbral a 5 unidades para mayor realismo
        $umbralBajo = 5;

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

    <div class="container py-4">
        
        <div class="mb-3">
            <a href="<?php echo e(route('producto.index')); ?>"
                class="text-decoration-none text-primary d-inline-flex align-items-center">
                <i class="bi bi-arrow-left me-2"></i>
                <span>Volver al Catálogo</span>
            </a>
        </div>

        
        <div class="card shadow-sm mb-5">
            <div class="card-body p-4">
                <div class="row g-4">
                    
                    <div class="col-12 col-md-5">
                        <div class="producto-imagen-wrapper rounded overflow-hidden bg-light d-flex align-items-center justify-content-center"
                            style="height: 400px;">
                            <img id="imagenPrincipal"
                                src="<?php echo e($producto->pro_imagen ? asset(ltrim($producto->pro_imagen, '/')) : asset('images/no-image.png')); ?>"
                                class="img-fluid" alt="<?php echo e($producto->pro_descripcion); ?>" loading="lazy"
                                style="max-height: 100%; object-fit: contain;">
                        </div>
                    </div>

                    
                    <div class="col-12 col-md-7">
                        <div id="alert-carrito"></div>

                        
                        <?php if($producto->categoria): ?>
                            <div class="mb-2">
                                <span class="badge bg-secondary"><?php echo e($producto->categoria->cat_descripcion); ?></span>
                            </div>
                        <?php endif; ?>

                        
                        <h1 class="h2 fw-bold mb-3"><?php echo e($producto->pro_descripcion); ?></h1>

                        
                        <div class="mb-3">
                            <span class="h3 text-primary fw-bold">
                                $<?php echo e(number_format((float) $producto->pro_precio_venta, 2, '.', ',')); ?>

                            </span>
                        </div>

                        
                        <?php if($producto->unidadMedidaVenta): ?>
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-box-seam text-muted"></i>
                                <span class="text-muted">Unidad de venta:</span>
                                <strong><?php echo e($producto->unidadMedidaVenta->um_descripcion); ?></strong>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mb-4 p-3 bg-light rounded">
                            <div class="d-flex align-items-center gap-2">
                                <span
                                    class="badge <?php echo e($stockClase == 'stock-agotado' ? 'bg-danger' : ($stockClase == 'stock-bajo' ? 'bg-warning text-dark' : 'bg-success')); ?>">
                                    <?php echo e($stockBadge); ?>

                                </span>
                                <span class="text-muted">
                                    Stock: <?php echo e($stockTexto); ?>

                                </span>
                            </div>
                        </div>

                        
                        <div class="d-grid gap-2">
                            <button id="btn-add-cart"
                                class="btn btn-lg <?php echo e($disabled ? 'btn-secondary' : 'btn-primary'); ?> d-flex align-items-center justify-content-center gap-2"
                                data-producto="<?php echo e($producto->id_producto); ?>" <?php echo e($disabled ? 'disabled' : ''); ?>>
                                <i class="bi bi-cart-plus fs-5"></i>
                                <span><?php echo e($disabled ? 'Producto Agotado' : 'Añadir al Carrito'); ?></span>
                            </button>
                        </div>

                        
                        <div class="mt-3">
                            <div class="alert alert-info" role="alert">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Aviso Importante:</strong> Para añadir más de una unidad de este producto, puedes modificar su cantidad en la pestaña de Carrito.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <?php if($productosRelacionados->count() > 0): ?>
            <div class="mt-5">
                <div class="text-center mb-4">
                    <h2 class="h3 fw-bold">Productos Relacionados</h2>
                    <p class="text-muted">Otros productos de la categoría
                        <strong><?php echo e($producto->categoria->cat_descripcion ?? 'similar'); ?></strong>
                    </p>
                </div>

                <div class="row g-3 g-md-4">
                    <?php $__currentLoopData = $productosRelacionados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productoRelacionado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="<?php echo e(route('producto.show', $productoRelacionado->id_producto)); ?>" class="text-decoration-none">
                                <div class="card h-100 shadow-sm producto-relacionado-card">
                                    <div class="position-relative bg-light" style="height: 200px;">
                                        <?php
                                            $imagenPath = 'images/productos/' . $productoRelacionado->id_producto . '.jpg';
                                        ?>
                                        <?php if(file_exists(public_path($imagenPath))): ?>
                                            <img src="<?php echo e(asset($imagenPath)); ?>" alt="<?php echo e($productoRelacionado->pro_descripcion); ?>"
                                                class="card-img-top p-3" loading="lazy" style="height: 100%; object-fit: contain;">
                                        <?php else: ?>
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body text-center p-3">
                                        <h5 class="card-title small mb-2" style="min-height: 2.5rem; line-height: 1.25rem;">
                                            <?php echo e(Str::limit($productoRelacionado->pro_descripcion, 40)); ?>

                                        </h5>
                                        <p class="text-muted small mb-2">
                                            <?php echo e($productoRelacionado->categoria->cat_descripcion ?? 'Producto'); ?>

                                        </p>
                                        <p class="text-primary fw-bold mb-0">
                                            $<?php echo e(number_format($productoRelacionado->pro_precio_venta, 2)); ?>

                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <style>
        .producto-relacionado-card {
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
        }

        .producto-relacionado-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            border-color: #007bff;
        }

        .badge-stock {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Documents\Martin Herrera\UNIVERSIDAD\CARRERA INGENIERIA EN SISTEMAS DE LA INFORMACIÓN\QUINTO SEMESTRE\Desarrollo_Basado_Plat_HERD\proyecto_integrador_ecommerce\resources\views/productos/show.blade.php ENDPATH**/ ?>