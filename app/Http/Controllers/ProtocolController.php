<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Protocol;

class ProtocolController extends Controller
{
    public function show(){
    	$request = Input::all();
    	$protocolos = Protocol::where('id_responsable',$request["id"])->get();
    	return view('viewProtocol',['protocols' => $protocolos] );
    }	

    public function exec_protocol(){
    	return "holi";
    }

    public function getProcessesTest(Request $request){
    
    	try {
            $request = GuzzleController::doTheRequest('GET', 'API/bpm/process?p=0&c=1000');
            return $request['data'];

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $error = Psr7\str($e->getResponse());
            } else {
                $error = "No se puede conectar al servidor de Bonita OS";
            }

            return $error;
        }
        echo GuzzleController::getToken();
    }

    public function initiateProcessTest($id){
        $response = GuzzleController::doTheRequest('POST', 'API/bpm/process/'.$id.'/instantiation');
        return $response;
    }

}
