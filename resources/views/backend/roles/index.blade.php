@extends('backend.layouts.app')

@section('content')
@include('backend.roles.create')
@include('backend.roles.edit')
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
                            <i class=" fa fa-cog"></i>
                            Roles
                            <div class="pull-right">
                                <button data-toggle="modal" data-target="#myModal" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo</button>
                                <a href="{{ URL::previous() }}" class="btn btn-danger"><i class="fa fa-reply"></i> Atras</a>
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
                                    @foreach($roles as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <td>{{$item->nombre}}</td>
                                        <td>{{$item->descripcion}}</td> 
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                        <td class="text-center">
                                            <button onclick="rol_editar('{{ route('roles.edit',$item->id) }}')" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal_edit">
                                                <i class="fa fa-edit"></i> Editar
                                            </button>
                                            <a href="{{ route('permisos.show',$item->id) }}" class="btn btn-xs btn-default">Permisos</a>
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
    function rol_editar(urli)
    {
        $.ajax({
            url: urli,
            type: 'GET',
            dataType: 'json',
            // data: {param1: 'value1'},
        })
        .done(function(result) {
            document.getElementById('id').value = result.id;
            document.getElementById('nombre').value = result.nombre;
            document.getElementById('descripcion').value = result.descripcion; 
            console.log(result);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    }
</script>
@endsection
