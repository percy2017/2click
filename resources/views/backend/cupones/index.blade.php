@extends('backend.layouts.app')

@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
@include('backend.cupones.create')
@include('backend.cupones.edit')

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            <span class="glyphicon glyphicon-th"></span>
                              Cupones del Sistema
                            <div class="pull-right">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_cupon_create"><i class="fa fa-plus"></i> Nuevo</button>
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
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Habilitado</th>  
                                        <th>Descuento</th>                             
                                        <th>Creado</th>
                                        <th class="text-center">Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($cupones as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <td>{{ $item->codigo }}</td>
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->descripcion }}</td>
                                        <td>
                                            @if($item->habilitado)
                                                <input type="checkbox" checked data-size="mini" data-toggle="toggle" data-on="SI" disabled> 
                                            @else
                                                <input type="checkbox" data-size="mini" data-toggle="toggle" data-off="NO" disabled>
                                            @endif
                                        </td>
                                        <td>{{ $item->descuento }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                        
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal_cupon_edit" onclick="editar('{{ route('cupones.edit',$item->id) }}')">
                                                <i class="fa fa-edit"></i>Editar
                                            </button> 
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
            document.getElementById('codigo').value = result.codigo;
            document.getElementById('nombre').value = result.nombre;
            document.getElementById('descripcion').value = result.descripcion;
            document.getElementById('descuento').value = result.descuento;
            // document.getElementById('habilitado').checked = ;
            // console.log(result.habilitado);
            if(result.habilitado == 1)
            {
                $("#habilitado").attr("checked", true)
            }
            

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
