@extends('backend.layouts.app')

@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
    @include('backend.permisos.create')
    @include('backend.permisos.edit')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>
                            Permisos del rol : <strong>{{$rol->nombre}} </strong>
                            <div class="pull-right">
                                <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo</a>
                                <a href="{{URL::previous()}}" class="btn btn-danger">
                                    <i class="fa fa-reply"></i> Atras
                                </a>
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
                                        <th>Nombre</th> 
                                        <th>Url</th> 
                                        <th>Creado</th> 
                                        <th>Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($permisos as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <td>{{$item->nombre}}</td> 
                                        <td>{{$item->ruta}}</td> 
                                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> Ver</a>
                                            <button onclick="permisos_editar('{{$item->nombre}}','{{$item->ruta}}','{{$item->id}}')" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#edit_permisos"><i class="fa fa-edit"></i> Editar</button>
                                            <a href="{{ route('permisos.destroy',$item->id) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Elimiar</a>
                                        </td> 
                                    </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <div class="panel-footer text-center">
                        {{$permisos->links()}}
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
