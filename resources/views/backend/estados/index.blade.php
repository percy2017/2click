@extends('backend.layouts.app')

@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
    @include('backend.estados.create')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            <i class="fa fa-clock-o"></i>
                              Estados de Pedidos
                            <div class="pull-right">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_estado_create"><i class="fa fa-plus"></i> Nuevo</button>
                                <a href="{{ URL::previous() }}" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i> Atras</a>
                            </div>
                        </h4>
                        
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
                                        <th class="text-center">Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($estados as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->descripcion }}</td> 
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                        
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Ver</a>
                                            <a href="#" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>Editar</a>
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
