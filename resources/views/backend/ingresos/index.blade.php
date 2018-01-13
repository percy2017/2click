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
                        <h4>
                            <span class="fa fa-money"></span>
                              Mis Ingresos
                            <div class="pull-right">
                                <a href="#" class="btn btn-default btn-sm"><i class="fa fa-signal"></i> Reporte</a>
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
                                        <th>Ingresado</th>
                                        <th class="text-center">Pedido#</th>
                                        <th>Producto</th>                           
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">SubTotal</th>
                                        <!-- <th class="text-center">Acciones</th>  -->
                                    </tr> 
                                </thead>
                                <tbody> 
                                  
                                    @foreach($ingresos as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td> 
                                        <td class="text-center"><u>{{ $item->pedido_id }}</u></td>
                                        <td>{{ $item->nombre }}</td>
                                        <td class="text-center">{{ number_format($item->precio,2) }}</td>
                                        <td class="text-center">{{ $item->cantidad }}</td>
                                        <td class="text-center">{{ number_format($item->precio * $item->cantidad,2) }}</td> 
                                        
                                        <!-- <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Ver</a>
                                            <a href="#" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>Editar</a>
                                        </td>  -->
                                       
                                    </tr> 
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="text-right"><label for="">Total en (Bs.) con {{ $items }} Items</label></td>
                                        <td class="text-center">{{ number_format($total,2) }}</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                    <div class="panel-footer text-center">
                        {{ $ingresos->links() }}
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
