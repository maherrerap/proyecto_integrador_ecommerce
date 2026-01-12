<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProxFac extends Model
{
    protected $table = 'pro_x_fac';
    public $timestamps = false;

    protected $fillable = [
        'id_factura',
        'id_producto',
        'pxf_cantidad',
        'pxf_precio',
        'pxf_subtotal',
        'estado_pxf'
    ];
}
