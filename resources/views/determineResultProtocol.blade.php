@extends('layouts.app')

@section('content')
   <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="bg-primary" style="height: 5px;"></div>
            <div class="card rounded-0">
                <div class="card-header bg-white">
                    <h5> Determinar resultado </h5>
                </div>
                <div class="card-body">
                    {{ Form::open(array('url' => 'protocol/storeResult')) }}
                        <fieldset>
                            <!-- Nombre -->
                            <div class="form-group row">
                                {{ Form::Label('resultado', 'Resultado:', ['class' => 'col-lg-4 col-form-label']) }}
                                <div class="col-lg-8">
                                    {{ Form::number('resultado', null, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::Label('finalizado_con', 'Protocolo finalizado con:', ['class' => 'col-lg-4 col-form-label']) }}
                                <div class="col-lg-8">
                                {{ Form::select('finalizado_con', ['1' => 'Exito', '0' => 'Fallas'], null, ['class' => 'form-control', 'name' => 'finalizado_con']) }}
                                </div>
                            </div>

                            <!-- Fecha fin -->
                            <div class="form-group row mb-4">
                                {{ Form::Label('fecha_fin', 'Fecha de finalización:', ['class' => 'col-lg-4 col-form-label']) }}
                                <div class="col-lg-8">
                                    {{ Form::date('fecha_fin', \Carbon\Carbon::now(), ['class' => 'form-control']) }}
                                </div>
                            </div>
                            
                            {{ Form::hidden('id', $id, ['class' => 'form-control' ]) }}

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
