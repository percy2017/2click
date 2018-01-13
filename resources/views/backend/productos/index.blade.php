@extends('backend.layouts.app')

@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
    <p>{{ config('app.mensaje_cargando') }}</p>
</div>
<div id="cargado" style="display:none;">
    <div class="container">
        @if(\Session::has('mensaje_info'))
            <div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Info!</strong> {{ \Session::get('mensaje_info') }}
            </div>
        @endif
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        
                        <h4>
                            <span class="fa fa-list-alt"></span>
                              Mis Productos
                            <div class="pull-right">
                                <a href="{{route('productos.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nuevo</a>
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
                                        <th>Imagen</th>
                                        <th>Categoria</th>
                                        <th>Negocio</th>
                                        <th>Nombre</th>
                                        <!-- <th>Descripcion</th> -->
                                        <th>Cantidad</th>  
                                        <th>Precio</th>
                                        <th>Habilitado</th>                                     
                                        <th>Actualizado</th>
                                        <th class="text-center">Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($productos as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <td>
                                            <a href="#" onclick="mostrar_imagen('{{asset('imagenes/productos/'.$item->imagen)}}','{{ $item->descripcion }}')">
                                                <img src="{{asset('imagenes/productos/'.$item->imagen)}}" alt="{{$item->nombre}}" class="img-responsive img-circle" style="width: 30px; height: 30px;">
                                            </a>
                                            
                                        </td>
                                        <th><u>{{$item->categoria}}</u></th>
                                         <th><u>{{$item->nombre_comercial}}</u></th>
                                        <td>{{ $item->nombre}}</td>
                                        <!-- <td>{{ $item->descripcion }}</td>  -->
                                        <td>{{ $item->cantidad }}</td> 
                                        <td>{{ $item->precio }}</td> 
                                        <td>
                                            @if($item->habilitado)
                                                <input type="checkbox" checked data-size="mini" data-toggle="toggle" data-on="SI" disabled> 
                                            @else
                                                <input type="checkbox" data-size="mini" data-toggle="toggle" data-off="NO" disabled>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('productos.edit',$item->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>Editar</a>
                                        </td> 
                                    </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                    <div class="panel-footer text-center">
                        {{$productos->links()}}
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
    function mostrar_imagen(imagen, descripcion)
    {
        $.alert({
            title:'',
            content: '<img class="img-responsive" width=100% src="'+imagen+'"> <p>'+descripcion+'</p>',
            escapeKey: 'close',
            theme: 'supervan',
            buttons: {
                close: function()
                {

                }
            }
        });
    }
</script>
@endsection
