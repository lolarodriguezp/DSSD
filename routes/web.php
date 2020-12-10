<?php

use App\User;
use App\Proyect;
use App\Protocol;
use App\Notification;
use App\Http\Controllers\RequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', function () {
    return view('home');
})->middleware('auth');

Route::get('register', function () {
    return redirect()->route('register');
})->middleware('auth');

Route::get('/', function () {
	return redirect()->route('login');
});

Route::get('create', function(){
	return view('createProyect', []);
})->middleware('jefe');

Route::get('addProtocols/{id}', function($id){
	$responsables = User::where('rol', 'Responsable')->pluck('name', 'id');
	return view('createProtocols', ['responsables' => $responsables, 'idProyect' => $id ]);
})->middleware('jefe');

Route::get('viewProtocols', function(){
	$activeProyects = Proyect::whereNotNull('id_case')->get();

	if($activeProyects != null){
		$proyectsId = array();

		foreach ($activeProyects as $proyect) {
			if(RequestController::instanceExists($proyect->id_case) &&
			   (RequestController::getTaskName($proyect->id_case) == "Ejecución local de todas sus actividades" ||
			    RequestController::getTaskName($proyect->id_case) == "Determinación de resultado") ){
				//Aca buscamos el user 
				$idUser = RequestController::getUserId();
				//Buscamos la tarea que este en ready para ese caseId y la asignamos
				$idTask = RequestController::getTask($proyect->id_case);
				RequestController::assignTask($idTask, $idUser);
				//Guardo en el proyecto el taskId actual para despues completar la tarea
				$proyect->update(array('id_task' => $idTask));
				$proyectsId [] = $proyect->id;
				
			}
		}
		$protocols = Protocol::Where('id_responsable', Auth::user()->id)->whereIn('id_proyecto', $proyectsId)->where('estado', '<>', 'Finalizado')->where('estado', '<>', 'Pendiente')->get();
	}else{
		$protocols = array();
	}
    
    return view('viewProtocols',  ['protocols' => $protocols]);
})->middleware('responsable');

Route::get('determineResultProtocol/{id}', function($id){
    return view('determineResultProtocol',  ['id' => $id]);
})->middleware('responsable');


Route::get('followProyects', function(){
   	$proyects = Proyect::all();
	return view('followProyect',  ['proyects' => $proyects]);
})->middleware('jefe');

Route::get('successfullNotice', function(){
	$activeProyects = Proyect::whereNotNull('id_case')->get();
	if($activeProyects != null){
		$proyectsId = array();
		foreach ($activeProyects as $proyect) {
			if(RequestController::instanceExists($proyect->id_case) &&
			   (RequestController::getTaskName($proyect->id_case) == "Notificación exitosa")){
				$user = User::where('id', $proyect->id_responsable)->first();
				//Aca buscamos el user que es jefe del proyecto del protocolo
				$idUser = RequestController::getUserIdByName($user->email);
				//Buscamos la tarea que este en ready para ese caseId y la asignamos
				$idTask = RequestController::getTask($proyect->id_case);
				RequestController::assignTask($idTask, $idUser);
				//Guardo en el proyecto el taskId actual para despues completar la tarea
				$proyect->update(array('id_task' => $idTask));
				$proyectsId [] = $proyect->id;
				
			}
		}
		$notifications = Notification::where('leida', 0)->where('tipo_notificacion', 'Exitosa')->whereIn('id_proyecto', $proyectsId)->get();
	}else{
		$notifications = array();
	}
    
    return view('successfullNotice',  ['notifications' => $notifications]);
})->middleware('jefe');

Route::get('errorsNotice', function(){
	$activeProyects = Proyect::whereNotNull('id_case')->get();
	if($activeProyects != null){
		$proyectsId = array();
		foreach ($activeProyects as $proyect) {
			if(RequestController::instanceExists($proyect->id_case) &&
			   (RequestController::getTaskName($proyect->id_case) == "Notificación fallida")){
				$user = User::where('id', $proyect->id_responsable)->first();
				//Aca buscamos el user que es jefe del proyecto del protocolo
				$idUser = RequestController::getUserIdByName($user->email);
				//Buscamos la tarea que este en ready para ese caseId y la asignamos
				$idTask = RequestController::getTask($proyect->id_case);
				RequestController::assignTask($idTask, $idUser);
				//Guardo en el proyecto el taskId actual para despues completar la tarea
				$proyect->update(array('id_task' => $idTask));
				$proyectsId [] = $proyect->id;
				
			}
		}
		$notifications = Notification::where('leida', 0)->where('tipo_notificacion', 'Fallida')->whereIn('id_proyecto', $proyectsId)->get();
	}else{
		$notifications = array();
	}

	return view('errorsNotice',  ['notifications' => $notifications]);
})->middleware('jefe');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/proyect/store', 'ProyectController@store')->name('proyect.store')->middleware('jefe');
Route::post('/protocol/store', 'ProtocolController@store')->name('protocol.store')->middleware('jefe');
Route::post('/protocol/exec', 'ProtocolController@exec_protocol')->name('protocol.exec_protocol')->middleware('responsable');
Route::post('/protocol/result', 'ProtocolController@result')->name('protocol.result')->middleware('responsable');
Route::post('/protocol/storeResult', 'ProtocolController@storeResult')->name('protocol.storeResult')->middleware('responsable');
Route::post('/notification/cancel', 'NotificationController@confirmFailedNotification')->name('notification.confirmFailedNotification')->middleware('jefe');
Route::post('/notification/continue', 'NotificationController@confirmFailedNotification')->name('notification.confirmFailedNotification')->middleware('jefe');
Route::post('/notification/accept', 'NotificationController@confirmSuccessfulNotification')->name('notification.confirmSuccessfulNotification')->middleware('jefe');


