@extends('backend.layouts.app')

@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
@include('backend.usuarios.create')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        
                        <h3>
                            Usuarios del Sistema :
                            <div class="pull-right">
                                <a href="{{route('roles.index')}}" class="btn btn-default btn-sm">Roles y Permisos</a>
                                <a href="{{route('localidades.index')}}" class="btn btn-default btn-sm">Localidades</a>
                                <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nuevo</a>
                                <a href="{{ URL::previous() }}" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i> Atras</a>
                            </div>
                        </h3>
                        
                    </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead> 
                                    <tr> 
                                        <th>#</th> 
                                        <th>Foto</th>
                                        <th>Rol</th>
                                        <th>Localidad</th>
                                        <th>Nombre</th>  
                                        <th>Origen</th>                                     
                                        <th>Correo</th> 
                                        <th>Creado</th>
                                        <th>Habilitado</th>
                                        <th>Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($usuarios as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <td>
                                            @if($item->redsocial)
                                                <a href="#" onclick="mostrar_imagen('{{$item->foto}}')">
                                                    <img src="{{$item->foto}}" class="img-responsive img-circle" style="width: 30px; height: 30px;">
                                                </a>
                                            @else
                                                <a href="#" onclick="mostrar_imagen('{{asset('imagenes/users/'.$item->foto)}}')">
                                                    <img src="{{asset('imagenes/users/'.$item->foto)}}" alt="{{$item->name}}" class="img-responsive img-circle" style="width: 30px; height: 30px;">
                                                </a>
                                            @endif
                                        </td>
                                        <td><u>{{$item->rol}}</u></td>
                                        <td><u>{{$item->localidad}}</u></td>
                                        <td>{{$item->name}}</td> 
                                        <td>{{$item->redsocial ? $item->redsocial : config('app.name')}}</td> 
                                        <td>{{$item->email}}</td> 
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                        <td>
                                            @if($item->habilitado)
                                                <input type="checkbox" checked data-size="mini" data-toggle="toggle" data-on="SI" disabled> 
                                            @else
                                                <input type="checkbox" data-size="mini" data-toggle="toggle" data-on="SI" disabled>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Ver</a>
                                            <a href="#" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>Editar</a>
                                            <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Eliminar</a>
                                        </td> 
                                    </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                    <div class="panel-footer text-center">
                        {{$usuarios->links()}}
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
