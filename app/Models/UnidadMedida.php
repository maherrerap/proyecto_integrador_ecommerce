<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    protected $table = 'unidades_medidas';
    protected $primaryKey = 'id_unidad_medida';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id_unidad_medida',
        'um_descripcion'
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'pro_um_venta', 'id_unidad_medida');
    }
}