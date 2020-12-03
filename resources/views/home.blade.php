@extends('layouts.app')

@section('content')
   <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="col-md-12 d-flex align-items-center mb-1">
            <h3>  Inicio </h3>
            <p class="font-weight-lighter ml-1"> - Panel de control</p> 
            </div>    
            <!-- <div class="card"> -->
                <!-- <div class="card-header d-flex align-items-baseline justify-content-between font-weight-bold"> Bienvenido @auth {{ Auth::user()->name }} @endauth ! <h4>  <span class="badge badge-secondary">@auth {{ Auth::user()->rol }} @endauth </span> </h4></div> -->
                <!-- <div class="card-body"> -->
                    <div class="d-flex align-items-baseline justify-content-between">
                        @if(Auth::user()->rol == "Jefe")
                        <div class="col-md-4 col-sm-12">
                            <div class="card mb-3 bg-primary text-white">
                            <div class="row no-gutters" >
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <h1><i class="fa fa-plus-square-o"></i></h1>
                                </div>
                                <div class="col-md-8">
                                <div class="card-body p-3" style="min-height:180px">
                                    <h5 class="card-title">Crear nuevo proyecto</h5>
                                    <p class="card-text">Configura un nuevo proyecyo, cargando todos los protocolos necesarios con sus etapas internas</p>   
                                </div>
                                </div>
                                <div class="col-md-12 p-2 text-center" style="background: rgba(0,0,0,0.1)">
                                    <a href="{{url('create')}}" class="text-white" >Ir ! <i class="fa fa-arrow-circle-right"></i></a>

                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="card mb-3 bg-success text-white">
                            <div class="row no-gutters" >
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <h1><i class="fa fa-question"></i></h1>
                                </div>
                                <div class="col-md-8">
                                <div class="card-body p-3" style="min-height:180px">
                                    <h5 class="card-title">Seguimiento de proyectos</h5>
                                    <p class="card-text">Consulta el estado actual de un proyecto.</p>   
                                </div>
                                </div>
                                <div class="col-md-12 p-2 text-center" style="background: rgba(0,0,0,0.1)">
                                    <a href="{{url('followProyects')}}" class="text-white" >Ir ! <i class="fa fa-arrow-circle-right"></i></a>

                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="card mb-3 bg-danger text-white" >
                            <div class="row no-gutters">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <h1><i class="fa fa-close"></i></h1>
                                </div>
                                <div class="col-md-8">
                                <div class="card-body p-3" style="min-height:180px">
                                    <h5 class="card-title">Notificaciones de fallas</h5>
                                    <p class="card-text">Ingresa para chequear los proyectos que fallaron y tomar una decisión</p>   
                                </div>
                                </div>
                                <div class="col-md-12 p-2 text-center" style="background: rgba(0,0,0,0.1)">
                                    <a href="{{url('errorsNotice')}}" class="text-white" >Ir ! <i class="fa fa-arrow-circle-right"></i></a>

                                </div>
                            </div>
                            </div>
                        </div>
                        @endif
                        @if(Auth::user()->rol == "Responsable")
                        <div class="col-md-4 col-sm-12">
                            <div class="card mb-3 bg-success text-white">
                            <div class="row no-gutters" >
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <h1><i class="fa fa-question"></i></h1>
                                </div>
                                <div class="col-md-8">
                                <div class="card-body p-3" style="min-height:180px">
                                    <h5 class="card-title">Seguimiento de proyectos</h5>
                                    <p class="card-text">Consulta el estado actual de un proyecto.</p>   
                                </div>
                                </div>
                                <div class="col-md-12 p-2 text-center" style="background: rgba(0,0,0,0.1)">
                                    <a href="{{url('viewProtocols')}}" class="text-white" >Ir ! <i class="fa fa-arrow-circle-right"></i></a>

                                </div>
                            </div>
                            </div>
                        </div>
                        @endif
                    </div>
                <!-- </div> -->
            <!-- </div> -->
        <!-- </div> -->
    </div>
</div>
@endsection

