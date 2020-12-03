<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyect extends Model
{
    public $timestamps = false;
    protected $table = 'proyectos';

    protected $fillable = [
        'id_proyecto' ,'nombre', 'fecha_inicio', 'fecha_fin', 'id_responsable'
    ];
}
