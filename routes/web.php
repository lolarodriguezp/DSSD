<?php

use App\User;
use App\Proyect;
use App\Protocol;

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
    $protocols = Protocol::Where('id_responsable', Auth::user()->id)->get();
    return view('viewProtocols',  ['protocols' => $protocols]);
})->middleware('responsable');

Route::get('followProyects', function(){
   	$proyects = Proyect::all();
	return view('followProyect',  ['proyects' => $proyects]);
})->middleware('jefe');

Route::get('errorsNotice', function(){
   	$protocols = Protocol::whereNotNull('exec_error');
	return view('errorsNotice',  ['protocols' => $protocols]);
})->middleware('jefe');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/proyect/store', 'ProyectController@store')->name('proyect.store')->middleware('jefe');
Route::post('/protocol/store', 'ProtocolController@store')->name('protocol.store')->middleware('jefe');
Route::get('/protocol/exec', 'ProtocolController@exec_protocol')->name('protocol.exec_protocol')->middleware('responsable');
