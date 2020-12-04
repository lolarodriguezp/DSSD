<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Protocol;
use App\Proyect;

class ProtocolController extends Controller
{
    public function show(){
    	$request = Input::all();
    	$protocolos = Protocol::where('id_responsable',$request["id"])->get();
    	return view('viewProtocol',['protocols' => $protocolos] );
    }	

    public function store(){
    	$request = Input::all();
        
        $cant = count($request["responsable"]);
        $id = $request["id_proyecto"];


        $protocolo = Proyect::where('id', $id)->first();

        $es_local = true;
        for ($i=0; $i < $cant ; $i++) { 
            //Cuando estoy procesando el protocolo con orden 1, me guardo el "es_local"
            if($request["orden"][$i] == 1){
                $es_local = ($request["ejecucion"][$i] == 0) ? 0 : 1;
            }
            Protocol::create([
                'nombre' => $request["nombre"][$i],
                'id_responsable' =>$request["responsable"][$i],
                'orden' => $request["orden"][$i],
                'es_local'=> ($request["ejecucion"][$i] == 0) ? 0 : 1,
                'id_proyecto' => $id, 
            ]);
        }

        if(!$es_local){
            RequestController::setearEsLocal($protocolo->id_case, $es_local);
        }

        RequestController::completarTarea($protocolo->id_task);

        return redirect()->route('home');
    }


}
