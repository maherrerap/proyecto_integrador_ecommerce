<?php

namespace App\Services;

class ImageOptimizerService
{
    /**
     * Optimiza una imagen: redimensiona y comprime
     * 
     * @param string $sourcePath Ruta de la imagen original
     * @param string $destinationPath Ruta donde guardar la imagen optimizada
     * @param int $maxWidth Ancho máximo (default: 800px)
     * @param int $quality Calidad de compresión 1-100 (default: 85)
     * @return bool True si se optimizó correctamente
     */
    public function optimize($sourcePath, $destinationPath = null, $maxWidth = 800, $quality = 85)
    {
        // Si no se especifica destino, sobrescribir el original
        if ($destinationPath === null) {
            $destinationPath = $sourcePath;
        }

        // Verificar que el archivo existe
        if (!file_exists($sourcePath)) {
            return false;
        }

        // Obtener información de la imagen
        $imageInfo = getimagesize($sourcePath);
        if ($imageInfo === false) {
            return false;
        }

        list($width, $height, $type) = $imageInfo;

        // Cargar la imagen según su tipo
        switch ($type) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($sourcePath);
                break;
            default:
                return false;
        }

        // Calcular nuevas dimensiones si la imagen es muy grande
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) ($height * ($maxWidth / $width));
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }

        // Crear nueva imagen redimensionada
        $optimizedImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preservar transparencia para PNG y GIF
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagecolortransparent($optimizedImage, imagecolorallocatealpha($optimizedImage, 0, 0, 0, 127));
            imagealphablending($optimizedImage, false);
            imagesavealpha($optimizedImage, true);
        }

        // Redimensionar con alta calidad
        imagecopyresampled(
            $optimizedImage,
            $image,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $width,
            $height
        );

        // Guardar la imagen optimizada
        $result = false;
        switch ($type) {
            case IMAGETYPE_JPEG:
                $result = imagejpeg($optimizedImage, $destinationPath, $quality);
                break;
            case IMAGETYPE_PNG:
                // PNG usa compresión 0-9 (invertido)
                $pngQuality = (int) (9 - ($quality / 100) * 9);
                $result = imagepng($optimizedImage, $destinationPath, $pngQuality);
                break;
            case IMAGETYPE_GIF:
                $result = imagegif($optimizedImage, $destinationPath);
                break;
        }

        // Liberar memoria
        imagedestroy($image);
        imagedestroy($optimizedImage);

        return $result;
    }

    /**
     * Obtiene el tamaño de un archivo en formato legible
     * 
     * @param string $filePath Ruta del archivo
     * @return string Tamaño formateado (ej: "120 KB")
     */
    public function getFileSize($filePath)
    {
        if (!file_exists($filePath)) {
            return '0 B';
        }

        $bytes = filesize($filePath);
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Calcula el porcentaje de reducción entre dos archivos
     * 
     * @param int $originalSize Tamaño original en bytes
     * @param int $optimizedSize Tamaño optimizado en bytes
     * @return float Porcentaje de reducción
     */
    public function getReductionPercentage($originalSize, $optimizedSize)
    {
        if ($originalSize == 0) {
            return 0;
        }

        return round((($originalSize - $optimizedSize) / $originalSize) * 100, 2);
    }
}
