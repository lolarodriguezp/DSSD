@extends('layouts.app')

@section('content')
   <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Protocolos asignados</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Orden</th>
                                <th>Ejecución</th>
                                <th>Proyecto</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($protocols as $protocol)
                            <tr>
                                <td>{{ $protocol->nombre }}</td>
                                <td>{{ $protocol->orden }}</td>
                                <td>@if ($protocol->es_local == 0) Local @else Remoto @endif</td>
                                <td>{{ (\App\Proyect::where('id', $protocol->id_proyecto)->pluck('nombre'))[0] }}</td>
                                <td>{{ $protocol->estado }}</td>
                                <td>
                                    {{ Form::open(array('url' => 'protocol/result')) }}
                                        {{ Form::hidden('id', $protocol->id, ['class' => 'form-control' ]) }}
                                        {{ Form::submit('Determinar resultado', ['class' => 'btn btn-primary']) }}
                                    {{ Form::close() }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="{{ URL::previous() }}">Volver</a>
        </div>
    </div>
</div>
@endsection
   