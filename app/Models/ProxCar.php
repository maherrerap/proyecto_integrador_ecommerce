<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProxCar extends Model
{
    protected $table = 'ecommerce.pro_x_car';
    public $timestamps = false;

    protected $fillable = [
        'id_carrito',
        'id_producto',
        'pxf_cantidad',
        'pxf_precio',
        'pxf_subtotal',
        'estado_pxf'
    ];

    /**
     * Obtiene los productos del carrito con su información completa
     */
    public static function obtenerProductosDelCarrito($idCarrito, $criterio = null) {
        $query = self::join('public.productos', 'public.productos.id_producto', '=', 'ecommerce.pro_x_car.id_producto')
            ->where('ecommerce.pro_x_car.id_carrito', $idCarrito)
            ->where('ecommerce.pro_x_car.estado_pxf', 'ABI')
            ->select(
                'public.productos.id_producto', 
                'public.productos.pro_descripcion', 
                'public.productos.pro_imagen',
                'ecommerce.pro_x_car.pxf_cantidad', 
                'ecommerce.pro_x_car.pxf_precio', 
                'ecommerce.pro_x_car.pxf_subtotal'
            );

        // Aplicar filtro de búsqueda si existe criterio
        if (!empty($criterio)) {
            $like = '%' . trim($criterio) . '%';
            
            $query->where(function ($q) use ($like) {
                $q->whereRaw("unaccent(public.productos.pro_descripcion) ILIKE unaccent(?)", [$like])
                  ->orWhereRaw("unaccent(public.productos.id_producto) ILIKE unaccent(?)", [$like]);
            });
        }

        return $query->orderBy('public.productos.id_producto', 'asc')->get();
    }
}
