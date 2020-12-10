<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Protocol;
use App\Proyect;
use App\User;
use App\Notification;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

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

            //Cuando estoy procesando el protocolo con orden 1, me guardo el "es_local" y lo seteo como Iniciado
            if($request["orden"][$i] == 1){
                $es_local = ($request["ejecucion"][$i] == 0) ? true : false;
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

    public function exec_protocol(){
        $request = Input::all();
        $protocoloId = $request["id"];

        $protocolo = Protocol::where('id', $protocoloId)->first();
        $proyecto = Proyect::where('id', $protocolo->id_proyecto)->first();

        //Seteo fecha de inicio y cambio estado a En ejecución 
        $protocolo->update(array('estado'=>'En ejecución','fecha_inicio'=>Carbon::now()));
        //Ejecuto la tarea en Bonita
        RequestController::runTask($proyecto->id_task);

        return redirect()->route('viewProtocols');

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
        $proyecto = Proyect::where('id', $protocolo->id_proyecto)->first();

        $protocolo->update(array('puntaje'=>$request["resultado"],'finalizado_con'=>$request["finalizado_con"], 'estado'=> 'Finalizado', 'fecha_fin' => $request["fecha_fin"]));

        if($request["finalizado_con"] == 1){
            $notificacion = "Exitosa";
        }else{
            $notificacion = "Fallida";
            //Seteo falla_ejecucion
            RequestController::setFallaEjecucion($proyecto->id_case, true);
        }
        
        //Ejecuto la tarea en Bonita
        RequestController::runTask($proyecto->id_task);

        //Creo la notificacion en la bd
        Notification::create([
            'tipo_notificacion' => $notificacion,
            'id_proyecto' => $proyecto->id
        ]);

        $user = User::where('id', $proyecto->id_responsable)->first();
        //Aca buscamos el user que es jede del proyecto del protocolo
        $idUser = RequestController::getUserIdByName($user->email);
        //Buscamos la proxima tarea seria (Notificacion exitosa o Notificacion fallida) y la asignamos al usuario
        $idTask = RequestController::getTask($proyecto->id_case);
        RequestController::assignTask($idTask, $idUser);
        //Actualizo el task_id actual
        $proyecto->update(array('id_task' => $idTask));

        return redirect()->route('home');
    }


}
