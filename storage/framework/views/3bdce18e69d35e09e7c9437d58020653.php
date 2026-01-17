<?php $__env->startSection('titulo', 'Productos'); ?>

<?php $__env->startSection('contenido'); ?>
    <div class="catalog-page">

        
        <div class="mb-3">
            <h1 class="catalog-title mb-3">CATÁLOGO DE PRODUCTOS</h1>

            
            <form method="GET" action="<?php echo e(route('producto.index')); ?>" class="search-container catalog-search" role="search">
                <input
                    type="text"
                    name="criterio"
                    value="<?php echo e(request('criterio')); ?>"
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

            
            <div class="mt-3 catalog-topbar">

                
                <div class="filters-row d-flex flex-wrap align-items-center gap-3">

                    <div class="d-flex flex-wrap align-items-center">
                        <span class="me-2" style="font-size:13px;color:#495057;">Categorías Disponibles:</span>

                        <?php
                            $cats = [
                                ['key'=>'Todos |  .','value'=>'ALL'],
                                ['key'=>'Alimentos | .','value'=>'ALI'],
                                ['key'=>'Ropa |  .','value'=>'RPA'],
                                ['key'=>'Ferretería |  .','value'=>'FRR'],
                                ['key'=>'Electrodomésticos','value'=>'ELE'],
                            ];
                            $selectedCats = (array) request('categorias', []);
                        ?>

                        <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $checked = $c['value']==='ALL'
                                    ? (empty($selectedCats) || in_array('ALL',$selectedCats))
                                    : in_array($c['value'],$selectedCats);
                            ?>
                            <label class="filter-pill mb-0">
                                <input type="checkbox" name="categorias[]" value="<?php echo e($c['value']); ?>"
                                       <?php echo e($checked ? 'checked' : ''); ?>

                                       onchange="this.form.submit()">
                                <span style="font-size:13px;"><?php echo e($c['key']); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="d-flex flex-wrap align-items-center">
                        <span class="me-2" style="font-size:13px;color:#495057;">Filtros Rápidos:</span>

                        <?php $quick = request('filtro',''); ?>

                        <label class="filter-pill mb-0">
                            <input type="radio" name="filtro" value="mas_vendidos"
                                   <?php echo e($quick==='mas_vendidos' ? 'checked' : ''); ?>

                                   onchange="this.form.submit()">
                            <span style="font-size:13px;">Más Vendidos  |</span>
                        </label>

                        <label class="filter-pill mb-0">
                            <input type="radio" name="filtro" value="novedades"
                                   <?php echo e($quick==='novedades' ? 'checked' : ''); ?>

                                   onchange="this.form.submit()">
                            <span style="font-size:13px;">Novedades  |</span>
                        </label>

                        <label class="filter-pill mb-0">
                            <input type="radio" name="filtro" value=""
                                   <?php echo e($quick==='' ? 'checked' : ''); ?>

                                   onchange="this.form.submit()">
                            <span style="font-size:13px;">Todos</span>
                        </label>
                    </div>
                </div>

                
                <div class="catalog-right-top">
                    <a href="<?php echo e(route('portada.index')); ?>" class="back-home">
                        Volver al Inicio...
                    </a>

                    <div class="catalog-pager">
                        <?php echo e($productos->onEachSide(1)->links()); ?>

                    </div>

                    <div class="mini-note">
                        Mostrando: <strong><?php echo e($productos->count()); ?></strong>
                        de <strong><?php echo e($productos->total()); ?></strong> Productos<br>
                        Marca tus productos como preferidos en la casilla.
                    </div>
                </div>

            </div>
        </div>

        
        <div class="row align-items-start">

            
            <div class="col-lg-9 col-md-8">
                <div class="row g-4">
                    <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
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
                        ?>

                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <div class="card product-card h-100 position-relative">
                                <div class="tag-categoria"><?php echo e($categoria); ?></div>

                                <div class="product-img-wrap">
                                    <img src="<?php echo e($img); ?>" alt="<?php echo e($producto->pro_descripcion); ?>" class="product-img">
                                </div>

                                <div class="card-body d-flex flex-column text-center">
                                    <div class="mb-2" style="font-size:18px;font-weight:700;color:#495057;">
                                        <?php echo e($producto->pro_descripcion); ?>

                                    </div>

                                    <div class="price mb-3">
                                        $<?php echo e(number_format((float)($precio ?? 0), 2, ',', '.')); ?>

                                    </div>

                                    <a href="<?php echo e($showUrl); ?>"
                                       class="btn <?php echo e($agotado ? 'btn-secondary' : 'btn-primary'); ?> btn-detalle mt-auto"
                                        <?php echo e($agotado ? 'style=pointer-events:none;opacity:.85;' : ''); ?>>
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-12">
                            <div class="alert alert-warning mb-0">
                                No hay productos para mostrar.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Herd\proyecto_integrador_ecommerce\resources\views/productos/index.blade.php ENDPATH**/ ?>