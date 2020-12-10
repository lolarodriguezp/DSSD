<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Protocol;
use App\Proyect;
use App\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class NotificationController extends Controller
{
    
    public function confirmSuccessfulNotification(){
    	$request = Input::all();
        $notificationId = $request["id"];

        $notification = Notification::where('id', $notificationId)->first();
        $proyecto = Proyect::where('id', $notification->id_proyecto)->first();

        //La marco como leida
        $notification->update(array('leida'=> 1));

        //Busco si hay algun protocolo de ese proyecto que no este finalizado
        $protocolo = Protocol::where('estado', '<>' , 'Finalizado')->where('id_proyecto', $proyecto->id)->orderBy('orden', 'ASC')->first();
        $ultimo_protocolo = true;
        if(!empty($protocolo)){
            $ultimo_protocolo = false;
        }
        //Seteo variable ultimo_protocolo
        if(!$ultimo_protocolo){
            RequestController::setUltimoProtocolo($proyecto->id_case, $ultimo_protocolo);

            $es_local = ($protocolo->es_local == 0) ? true : false;
            if(!$es_local){
                RequestController::setEsLocal($proyecto->id_case, false);
                RequestController::setidProyect($proyecto->id_case, $protocolo->id_proyecto);
                RequestController::setidProtocol($proyecto->id_case, $protocolo->id);
                $protocolo->update(array('estado'=> 'Iniciado'));
            }
            
        }
        //Ejecuto la tarea en Bonita
        RequestController::runTask($proyecto->id_task);

        return redirect()->route('home');
    }

    public function confirmFailedNotification(){
    	$request = Input::all();
        $notificationId = $request["id"];

        $notification = Notification::where('id', $notificationId)->first();
        $proyecto = Proyect::where('id', $notification->id_proyecto)->first();

        //La marco como leida
        $notification->update(array('leida'=> 1));

        if($request["que_hacer"] == 1){
            RequestController::setContinuarProyecto($proyecto->id_case, true);
            //Busco si hay algun protocolo de ese proyecto que no este finalizado
            $protocolo = Protocol::where('estado', '<>' , 'Finalizado')->where('id_proyecto', $proyecto->id)->orderBy('orden', 'ASC')->first();
            $ultimo_protocolo = true;
            if(!empty($protocolo)){
                $ultimo_protocolo = false;
            }
            //Seteo variable ultimo_protocolo
            if(!$ultimo_protocolo){
                $es_local = ($protocolo->es_local == 0) ? true : false;
                if(!$es_local){
                    RequestController::setEsLocal($proyecto->id_case, false);
                    RequestController::setidProyect($proyecto->id_case, $protocolo->id_proyecto);
                    RequestController::setidProtocol($proyecto->id_case, $protocolo->id);
                    $protocolo->update(array('estado'=> 'Iniciado'));
                }
            }
            //Ejecuto la tarea en Bonita
            RequestController::runTask($proyecto->id_task);
        }

        //Ejecuto la tarea en Bonita
        RequestController::runTask($proyecto->id_task);

        return redirect()->route('home');
    }


}
