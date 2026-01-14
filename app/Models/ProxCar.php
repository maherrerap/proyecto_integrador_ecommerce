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
}
