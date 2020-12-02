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

    public function store(){
    	$request = Input::all();
        
        $cant = count($request["responsable"]);
        $id = $request["id_proyecto"];

        for ($i=0; $i < $cant ; $i++) { 
            Protocol::create([
                'nombre' => $request["nombre"][$i],
                'id_responsable' =>$request["responsable"][$i],
                'orden' => $request["orden"][$i],
                'es_local'=> ($request["ejecucion"][$i] == 0) ? 0 : 1,
                'id_proyecto' => $id, 
            ]);
        }

        return redirect()->route('home');
    }


}
