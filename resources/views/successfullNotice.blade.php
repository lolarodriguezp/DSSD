@extends('layouts.app')

@section('content')
   <div class="container">
    <div class="row justify-content-center">       
        @if( count($notifications) > 0 )
            <div class="col-md-10">
                <div class="bg-success" style="height: 5px;"></div>
                <div class="card rounded-0">
                    <div class="card-header bg-white">
                        <h5> Notificaciones de éxito </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Proyecto</th>                                
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                <tr>
                                    <td> El proyecto{{ (\App\Proyect::where('id', $notification->id_proyecto)->pluck('nombre'))[0]  }} ha ejecutado otro protocolo exitosamente!.</td>
                                    <td>
                                        {{ Form::open(array('url' => 'notification/accept')) }}
                                            {{ Form::hidden('id', $notification->id, ['class' => 'form-control' ]) }}
                                            {{ Form::submit('Aceptar', ['class' => 'btn btn-success']) }}
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <a href="{{ URL::previous() }}" class="btn btn-info" >Volver</a>
            </div>
        @else
            <div class="col-md-6">
                <h3>No hay notificaciones de éxito</h3>
                <a href="{{ URL::previous() }}" class="btn btn-info" >Volver</a>
            </div>
        @endif
    </div>
</div>
@endsection