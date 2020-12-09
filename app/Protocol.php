<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    public $timestamps = false;
    protected $table = 'protocolos';

    protected $fillable = [
        'id', 'nombre', 'id_responsable', 'orden', 'es_local','fecha_inicio', 'fecha_fin', 'estado', 'puntaje', 'finalizado_con', 'id_proyecto', 'id_task'
    ];
}
