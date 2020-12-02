@extends('layouts.app')

@section('content')
   <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="bg-primary" style="height: 5px;"></div>
            <div class="card rounded-0">
                <div class="card-header bg-white">
                    <h5> Formulario para crear proyecto </h5>
                </div>
                <div class="card-body">
                    {{ Form::open(array('url' => 'proyect/store')) }}
                        <fieldset>
                            <!-- Nombre -->
                            <div class="form-group row">
                                {{ Form::Label('nombre_proyecto', 'Nombre del proyecto:', ['class' => 'col-lg-4 col-form-label']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('nombre_proyecto', null, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <!-- Fecha inicio -->
                            <div class="form-group row">
                                {{ Form::Label('fecha_inicio', 'Fecha de inicio:', ['class' => 'col-lg-4 col-form-label']) }}
                                <div class="col-lg-8">
                                    {{ Form::date('fecha_inicio', \Carbon\Carbon::now(), ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <!-- Fecha fin -->
                            <div class="form-group row mb-4">
                                {{ Form::Label('fecha_fin', 'Fecha de finalización:', ['class' => 'col-lg-4 col-form-label']) }}
                                <div class="col-lg-8">
                                    {{ Form::date('fecha_fin', \Carbon\Carbon::now(), ['class' => 'form-control']) }}
                                </div>
                            </div>
                            
                            {{ Form::hidden('idCreator', Auth::user()->id, ['class' => 'form-control' ]) }}

                            <!-- Submit Button -->
                            <div class="form-group">
                                <div class="text-right">
                                    {{ Form::submit('Guardar', ['class' => 'btn btn-primary']) }}
                                    <a href="{{ URL::previous() }}" class="btn btn-danger">Volver</a>
                                </div>
                            </div>
                        </fieldset>
                    {{ Form::close() }}
                </div>
            </div>
           
        </div>

    </div>

@endsection
