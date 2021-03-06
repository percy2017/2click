@extends('backend.layouts.app')

@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>
                            Localidades
                            <div class="pull-right">
                                <a href="#" data-toggle="modal" data-target="#modalNotificacionCreate" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nuevo</a>
                                <a href="{{URL::previous()}}" class="btn btn-danger btn-sm">
                                   <i class="fa fa-reply"></i> Atras
                                </a>
                            </div>
                        </h3>              
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead> 
                                    <tr> 
                                        <th>#</th> 
                                        <th>Nombre</th> 
                                        <th>Descripcion</th> 
                                        <th>Creado</th> 
                                        <th>Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($localidades as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <td>{{$item->nombre}}</td> 
                                        <td>{{$item->descripcion}}</td> 
                                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> Ver</a>
                                           <button onclick="notificaciones_editar('{{$item->ruta}}','{{$item->mensaje}}','{{$item->id}}')" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalNotificacionEdit"><i class="fa fa-edit"></i> Editar</button>
                                            <a href="" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Elimiar</a>
                                        </td> 
                                    </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer text-center">
                        {{ config('app.myfooter') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('myscript')
<script>
    $(document).ready(function() 
    {
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
    });
</script>
@endsection
