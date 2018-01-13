@extends('backend.layouts.app')

@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
    <p>{{ config('app.mensaje_cargando') }}</p>
</div>
<div id="cargado" style="display:none;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>
                            <i class="fa fa-gears"></i>
                            Items  del Sistemas
                            <div class="pull-right">
                                <a href="{{ URL::previous() }}" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i> Atras</a>
                            </div>
                        </h3>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead> 
                                    <tr> 
                                        <th>#</th> 
                                        <th>Actualizado</th>
                                        <th>Categoria</th>
                                        <th>Nombre</th>
                                        
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Habilitado</th>
                                        <th>Negocio</th>
                                        <th>Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($items as $item)
                                    <tr>                                 
                                        <th>{{ $item->id }}</th> 
                                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                         <td>{{ $item->categoria }}</td>
                                        <td>
                                            <a href="#" onclick="mostrar_imagen('{{ asset('imagenes/productos/'.$item->imagen) }}','{{ $item->descripcion }}')">
                                                {{ $item->nombre }}
                                            </a>
                                        </td>
                                       
                                        <td class="text-center">{{ number_format($item->precio,2) }}</td>
                                        <td class="text-center">{{ $item->cantidad }}</td>
                                        <td>
                                            @if($item->habilitado)
                                                <input type="checkbox" checked data-size="mini" data-toggle="toggle" data-on="SI" disabled> 
                                            @else
                                                <input type="checkbox" data-size="mini" data-toggle="toggle" data-on="SI" disabled>
                                            @endif
                                        </td>
                                         <td>
                                            <a href="#" onclick="mostrar_imagen('{{ asset('imagenes/proveedores/'.$item->logo) }}','Dir: {{ $item->direccion }} - Atencio: {{ $item->atencion }}')">
                                                {{ $item->nombre_comercial }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Ver</a>
                                        </td>
                                    </tr> 
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-right"><label for="">Totales</label></td>
                                        <td>{{ $itemsT }}</td>
                                        <td class="text-center">{{ number_format($precioT,2) }}</td>
                                        <td class="text-center">{{ $cantidadT }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                    <div class="panel-footer text-center">
                        {{$items->links()}}
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
