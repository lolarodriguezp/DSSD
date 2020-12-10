<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps = false;
    protected $table = 'notificaciones';

    protected $fillable = [
        'id', 'tipo_notificacion' , 'leida', 'id_proyecto'
    ];
}
