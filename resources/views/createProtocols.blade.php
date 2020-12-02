@extends('layouts.app')

@section('content')
   <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="bg-primary" style="height: 5px;"></div>
            <div class="card rounded-0">
                <div class="card-header bg-white">
                    <h5> Agregar protocolos al proyecto </h5>
                </div>
                <div class="card-body">
                    {{ Form::open(array('url' => 'protocol/store')) }}
                        <fieldset>
                        <div class="form-group">
                                <button id="adicional" name="adicional" type="button" class="btn btn-primary">Añadir protocolo</button>
                            </div>

                            <div class="form-group row" id="tabla">
                                <div class="fila-fija">
                                    <div class="form-group">
                                        {{ Form::Label('nombre', 'Nombre del protocolo:', ['class' => 'col-lg-10 col-form-label']) }}
                                        <div class="col-lg-10">
                                            {{ Form::text('nombre', null, ['class' => 'form-control', 'name' => 'nombre[]']) }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::Label('id_responsable', 'Responsable:', ['class' => 'col-lg-10 col-form-label']) }}
                                        <div class="col-lg-10">
                                            {{ Form::select('id_responsable', $responsables, null, ['class' => 'form-control', 'name' => 'responsable[]']) }}
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        {{ Form::Label('local', 'Ejecución:', ['class' => 'col-lg-10 col-form-label']) }}
                                        <div class="col-lg-10">
                                        {{ Form::select('id_responsable', ['0' => 'Local', '1' => 'Remota'], null, ['class' => 'form-control', 'name' => 'ejecucion[]']) }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::Label('orden', 'Orden', ['class' => 'col-lg-10 col-form-label']) }}
                                        <div class="col-lg-6">
                                            {{ Form::number('orden', null, ['class' => 'form-control', 'name' => 'orden[]']) }}
                                        </div>
                                    </div>
                                    <div class="form-group eliminar">
                                        <div class="col-lg-10 col-lg-offset-2">
                                            <input class="btn btn-danger mt-2" type="button" value="Eliminar protocolo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::hidden('id_proyecto', $idProyect, ['class' => 'form-control' ]) }}
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
      