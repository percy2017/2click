@extends('backend.layouts.app')

@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
    @include('backend.categorias.create')
    @include('backend.categorias.edit')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        
                        <h4>
                            <span class="fa fa-th"></span>
                              Categoria
                            <div class="pull-right">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_create"><i class="fa fa-plus"></i> Nuevo</button>
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
                                    @foreach($categorias as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->descripcion }}</td> 
                                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                        
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal_edit" onclick="editar('{{ route('categorias.edit',$item->id) }}')"><i class="fa fa-edit"></i>Editar</button>
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
    function editar(urli)
    {   
        // alert(urli);
        $.ajax({
            url: urli,
            type: 'GET',
            dataType: 'json',
        })
        .done(function(result) {
            document.getElementById('id').value = result.id;
            document.getElementById('nombre').value = result.nombre;
            document.getElementById('descripcion').value = result.descripcion;
            // console.log(result);
        })
        .fail(function(result) {
            // console.log("error"+result);
        })
        .always(function() {
            // console.log("complete");
        });
        
    
    }
</script>
@endsection
