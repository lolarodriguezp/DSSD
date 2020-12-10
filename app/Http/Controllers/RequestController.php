<?php

namespace App\Http\Controllers;

use App\Proyect;
use App\Protocol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
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

    public static function getUserId(){
        $response = GuzzleController::doTheRequest('GET', 'API/identity/user?f=userName='.Auth::user()->email);   
        $idUser = $response['data'][0]->id; #Obtengo el id del usuario

        return $idUser;
    }

    public static function getUserIdByName($user){
        $response = GuzzleController::doTheRequest('GET', 'API/identity/user?f=userName='.$user);   
        $idUser = $response['data'][0]->id; #Obtengo el id del usuario

        return $idUser;
    }

    public static function getProcessId(){
        $response = GuzzleController::doTheRequest('GET', 'API/bpm/process?p=0&c=1000');   
        $idProceso = $response['data'][0]->id; #Obtengo el id del proceso

        return $idProceso;
    }

    public static function instantiateProcess($idProceso){
        $response = GuzzleController::doTheRequest('POST', 'API/bpm/process/'.$idProceso.'/instantiation');   
        $caseId = $response['data']->caseId; #Obtengo el id de la instancia

        return $caseId;
    }

    public static function assignTask($idTask, $idUser){
        $data = array(
            "assigned_id" => $idUser
        );
        $response = GuzzleController::doTheRequest('PUT', 'API/bpm/userTask/'.$idTask, $data);   
        return $response;
    }

    public static function getTask($caseId){
        $response = GuzzleController::doTheRequest('GET', 'API/bpm/activity?p=0&c=1000&f=caseId='.$caseId);   
        return ($response['data'][0]->id);
    }

    public static function setEsLocal($idCase, $es_local){
        $data = array(
            "type" => "java.lang.Boolean", 
            "value" => $es_local
        );
        $response = GuzzleController::doTheRequest('PUT', 'API/bpm/caseVariable/'.$idCase.'/es_local', $data);   
        return $response;
    }

    public static function runTask($idTask){
        $response = GuzzleController::doTheRequest('POST', 'API/bpm/userTask/'.$idTask.'/execution');   
        return $response;
    }

    public static function instanceExists($idCase){
        $response = GuzzleController::doTheRequest('GET', 'API/bpm/activity?p=0&c=1000&f=caseId='.$idCase);
        if(empty($response)){
            return false;
        }
        return true;
        
    }

    public static function getTaskName($idCase){
        $response = GuzzleController::doTheRequest('GET', 'API/bpm/activity?p=0&c=1000&f=caseId='.$idCase);   
        if(empty($response)){
            $name = "";
        }else{
            $name = $response['data'][0]->name;
        }  
        return $name;
    }

    public static function setUltimoProtocolo($idCase, $ultimo_protocolo){
        $data = array(
            "type" => "java.lang.Boolean", 
            "value" => $ultimo_protocolo
        );
        $response = GuzzleController::doTheRequest('PUT', 'API/bpm/caseVariable/'.$idCase.'/ultimo_protocolo', $data);   
        return $response;
    }

    public static function setFallaEjecucion($idCase, $falla_ejecucion){
        $data = array(
            "type" => "java.lang.Boolean", 
            "value" => "true"
        );
        $response = GuzzleController::doTheRequest('PUT', 'API/bpm/caseVariable/'.$idCase.'/falla_ejecución', $data);
        return $response;
    }

    public static function setContinuarProyecto($idCase, $continuar_proyecto){
        $data = array(
            "type" => "java.lang.Boolean", 
            "value" => $continuar_proyecto
        );
        $response = GuzzleController::doTheRequest('PUT', 'API/bpm/caseVariable/'.$idCase.'/continuar_proyecto', $data);   
        return $response;
    }

    public static function setidProyect($idCase, $idProyect){
        $data = array(
            "type" => "java.lang.Boolean", 
            "value" => $idProyect
        );
        $response = GuzzleController::doTheRequest('PUT', 'API/bpm/caseVariable/'.$idCase.'/idProy', $data);   
        return $response;
    }

    public static function setidProtocol($idCase, $idProtocol){
        $data = array(
            "type" => "java.lang.Boolean", 
            "value" => $idProtocol
        );
        $response = GuzzleController::doTheRequest('PUT', 'API/bpm/caseVariable/'.$idCase.'/idProt', $data);   
        return $response;
    }

    
}
