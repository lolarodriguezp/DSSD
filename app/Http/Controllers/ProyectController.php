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
        // Proyect::create([
        //     'nombre' => Input::get('nombre_proyecto'),
        //     'fecha_inicio' => Input::get('fecha_inicio'),
        //     'fecha_fin' => Input::get('fecha_fin'),
        //     'id_responsable' => Input::get('idCreator'),
        // ]);
        
        // $id = Proyect::where('nombre', Input::get('nombre_proyecto'))->first();

        // //Busco los procesos
        // $request = GuzzleController::doTheRequest('GET', 'API/bpm/process?p=0&c=1000');
        // $data = $request['data'];
        // //Ni idea como acceder al id pero veremos
        // $idProceso = $data->id;
        
        // //Aca se instanciaria el proceso
        // GuzzleController::doTheRequest('POST', 'API/bpm/process/'.$idProceso.'/instantiation');

        // return Redirect::to('addProtocols/'.$id->id) ;
        return Redirect::to('addProtocols/1') ;
    }
}
