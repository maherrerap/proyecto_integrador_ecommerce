<?php

use App\Services\ImageOptimizerService;

/*
|--------------------------------------------------------------------------
| Script de Optimización de Imágenes de Productos
|--------------------------------------------------------------------------
| 
| Este script optimiza las imágenes de productos existentes o nuevas.
| Redimensiona a 800px máximo y comprime al 85% de calidad.
|
| USO:
| php artisan tinker
| include('scripts/optimize_product_images.php');
|
*/

$optimizer = new ImageOptimizerService();
$productImagesPath = public_path('images/productos');

if (!is_dir($productImagesPath)) {
    echo "❌ Directorio de productos no encontrado: {$productImagesPath}\n";
    return;
}

$images = glob($productImagesPath . '/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

if (empty($images)) {
    echo "ℹ️  No se encontraron imágenes para optimizar.\n";
    return;
}

echo "🚀 Iniciando optimización de " . count($images) . " imagen(es)...\n";
echo str_repeat("-", 60) . "\n";

$totalOriginalSize = 0;
$totalOptimizedSize = 0;
$optimizedCount = 0;

foreach ($images as $imagePath) {
    $filename = basename($imagePath);
    $originalSize = filesize($imagePath);
    $totalOriginalSize += $originalSize;

    echo "📸 Procesando: {$filename}\n";
    echo "   Tamaño original: " . $optimizer->getFileSize($imagePath) . "\n";

    // Crear copia de respaldo (opcional)
    // copy($imagePath, $imagePath . '.backup');

    // Optimizar la imagen
    $result = $optimizer->optimize($imagePath, null, 800, 85);

    if ($result) {
        clearstatcache(true, $imagePath);
        $optimizedSize = filesize($imagePath);
        $totalOptimizedSize += $optimizedSize;
        $reduction = $optimizer->getReductionPercentage($originalSize, $optimizedSize);

        echo "   ✅ Optimizada: " . $optimizer->getFileSize($imagePath) .
            " (Reducción: {$reduction}%)\n";
        $optimizedCount++;
    } else {
        echo "   ❌ Error al optimizar\n";
        $totalOptimizedSize += $originalSize;
    }

    echo "\n";
}

echo str_repeat("=", 60) . "\n";
echo "📊 RESUMEN:\n";
echo "   Total procesadas: " . count($images) . "\n";
echo "   Exitosas: {$optimizedCount}\n";
echo "   Tamaño total original: " . round($totalOriginalSize / 1024 / 1024, 2) . " MB\n";
echo "   Tamaño total optimizado: " . round($totalOptimizedSize / 1024 / 1024, 2) . " MB\n";
$globalReduction = $optimizer->getReductionPercentage($totalOriginalSize, $totalOptimizedSize);
echo "   Reducción global: {$globalReduction}%\n";
echo "   Ahorro: " . round(($totalOriginalSize - $totalOptimizedSize) / 1024 / 1024, 2) . " MB\n";
echo str_repeat("=", 60) . "\n";
echo "✅ Optimización completada!\n";
