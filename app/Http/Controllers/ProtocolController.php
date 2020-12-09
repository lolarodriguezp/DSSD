<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Protocol;
use App\Proyect;
use Illuminate\Support\Facades\Redirect;

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


        $proyecto = Proyect::where('id', $id)->first();

        $es_local = true;
        for ($i=0; $i < $cant ; $i++) { 
            $id_protocol = Protocol::create([
                'nombre' => $request["nombre"][$i],
                'id_responsable' =>$request["responsable"][$i],
                'orden' => $request["orden"][$i],
                'es_local'=> ($request["ejecucion"][$i] == 0) ? 0 : 1,
                'id_proyecto' => $id, 
            ])->id;;

            //Cuando estoy procesando el protocolo con orden 1, me guardo el "es_local"
            if($request["orden"][$i] == 1){
                $es_local = ($request["ejecucion"][$i] == 0) ? 0 : 1;
                $protocol = Protocol::where('id', $id_protocol);
                $protocol->update(array('estado'=> 'Iniciado'));
            }
        }

        if(!$es_local){
            RequestController::setEsLocal($proyecto->id_case, $es_local);
        }

        RequestController::runTask($proyecto->id_task);

        return redirect()->route('home');
    }

    public function result(){
    	$request = Input::all();
        $protocoloId = $request["id"];
        return Redirect::to('determineResultProtocol/'.$protocoloId) ;
    }

    public function storeResult(){
    	$request = Input::all();
        $protocoloId = $request["id"];
        $protocolo = Protocol::where('id', $protocoloId)->first();

        $protocolo->update(array('puntaje'=>$request["resultado"],'finalizado_con'=>$request["finalizado_con"], 'estado'=> 'Finalizado', 'fecha_fin' => $request["fecha_fin"]));

        return redirect()->route('home');
    }


}
