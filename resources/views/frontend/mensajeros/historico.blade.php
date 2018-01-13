@extends('frontend.layouts.app')
@section('mystyle')

@endsection
@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
    <p>{{ config('app.mensaje_cargando') }}</p>
</div>
<div id="cargado" style="display:none;">
    @include('frontend.mensajeros.productos_modal')
    @include('frontend.mensajeros.indicaciones_modal')

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                          <i class="fa fa-clock-o"></i>
                            Historico
                            <div class="pull-right">
                                
                                <a href="{{ URL::previous() }}" class="btn btn-danger"><i class="fa fa-reply"></i> Atras</a>
                            </div>
                        </h4>
                    </div>

                    <div class="panel-body">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover table-bordered">
                                <tr>
                                  <th>#</th>
                                  <th>Solicitado</th>
                                  <th>Cliente</th>
                                  <!-- <th>Foto</th> -->
                                  <th>Destino</th>
                                  <th class="text-center">Acciones</th>
                                </tr>
                                @foreach($pedidos as $item)
                                <tr>
                                  <!-- <td>{{$loop->iteration}}</td> -->
                                  <td>{{ $item->id }}</td>
                                  <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                  
                                  <td>{{ $item->name }}</td>
                                  <!-- <td>
                                    @if($item->redsocial)
                                        <a href="#" onclick="mostrar_imagen('{{$item->foto}}')">
                                            <img src="{{$item->foto}}" class="img-responsive img-circle" style="width: 30px; height: 30px;">
                                        </a>
                                    @else
                                        <a href="#" onclick="mostrar_imagen('{{asset('imagenes/users/'.$item->foto)}}')">
                                            <img src="{{asset('imagenes/users/'.$item->foto)}}" alt="{{$item->name}}" class="img-responsive img-circle" style="width: 30px; height: 30px;">
                                        </a>
                                    @endif

                                  </td> -->
                                  <td>{{ $item->destino }}</td>
                                  <td class="text-center">
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#productos_modal" onclick="carrito('{{ route('mensajero.productos',$item->id) }}')">
                                                <i class="fa fa-list"></i> Productos
                                        </button>
                                        <a href="{{ route('mensajero.mapa',$item->id) }}" class="btn btn-default"><i class="fa fa-map-marker"></i>Mapa</a>
                                  </td>
                                @endforeach
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
    function carrito(urli)
    {
      // alert(urli);
        document.getElementById('cargando_carrito').style.display = 'block';
        document.getElementById('tabla_carrito').style.display = 'none';
        $.ajax({
            url: urli,
            type: 'GET',
            dataType: 'json',
            data: {param1: 'value1'},
        })
        .done(function(result) 
        {
            var cadena ='<div class="table-responsive">';
                cadena +='<table class="table table-hover table-bordered">';
                cadena +='<thead><tr>';
                cadena +='<th>#</th>';
                cadena +='<th>Productos</th>';
                cadena +='<th>Cant</th>';
                cadena +='<th>Negocio</th>';
                cadena +='<th>Destino</th>';
                cadena +='</tr></thead><tbody>';
            for (var i = 0; i < result.length; i++) 
            {
                cadena+='<tr><th>'+result[i].id+'</th>';
                cadena+='<th> <a href="#">'+result[i].nombre+'</a></th>';
                cadena+='<th>'+result[i].cantidad+'</th>';
                cadena+='<th><a href="#">'+result[i].nombre_comercial+'</a></th>';
                cadena+='<th>'+result[i].direccion+'</th>';
            }
            cadena +='</tbody></table></div>';
            document.getElementById('tabla_carrito').innerHTML = cadena;
            document.getElementById('cargando_carrito').style.display = 'none';
            document.getElementById('tabla_carrito').style.display = 'block';
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

