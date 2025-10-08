<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table = "prestamos";
    protected $primaryKey = "prestamo_id";
    protected $fillable = [
        'libro_id',
        'usuario_id',
        'fecha_prestamo',
        'fecha_devolucion',
        'fecha_devolucion_real',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'libro_id', 'libro_id');
    }
}
