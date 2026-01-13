<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'id_categoria';

    public $timestamps = false;

    // CLAVE PRIMARIA CHAR/VARCHAR
    public $incrementing = false;
    protected $keyType = 'string';

    // (Opcional pero recomendado) asegura que SIEMPRE sea string
    protected $casts = [
        'id_categoria' => 'string',
    ];
}
