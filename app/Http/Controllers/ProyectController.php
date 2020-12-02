<?php

namespace App\Http\Controllers;

use App\Proyect;
use App\Protocol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;

class ProyectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    protected function store()
    {   $request = Input::all();
        Proyect::create([
            'nombre' => Input::get('nombre_proyecto'),
            'fecha_inicio' => Input::get('fecha_inicio'),
            'fecha_fin' => Input::get('fecha_fin'),
            'id_responsable' => Input::get('idCreator'),
        ]);
        
        $id = Proyect::where('nombre', Input::get('nombre_proyecto'))->first();

        //Busco el id del proceso
        $idProceso = RequestController::getProcesoId();
        
        
        //Aca se instanciaria el proceso
        $idCase = RequestController::instanciarProceso($idProceso);

        //Aca buscamos el user 
        $idUser = RequestController::getUserId();

        //Buscamos la primer tarea 
        $idTarea = RequestController::obtenerTarea($idCase);
        RequestController::asignarTarea($idTarea, $idUser);

        // return Redirect::to('addProtocols/'.$id->id) ;
        return Redirect::to('addProtocols/1', [$idCase]) ;
    }
}
