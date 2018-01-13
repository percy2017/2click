@extends('frontend.layouts.app')
@section('mystyle')

@endsection
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
                        <h4>
                          <i class="fa fa-shopping-cart"></i>
                            Carrito
                            <div class="pull-right">
                                <a href="{{ route('pedido.index') }}" class="btn btn-success"><i class="fa fa-location-arrow"></i> Pedir</a>
                                <button class="btn btn-primary"><span class="fa fa-search"></span> Buscar</button>
                                <a href="{{ URL::previous() }}" class="btn btn-danger"><i class="fa fa-reply"></i> Atras</a>
                            </div>
                        </h4>
                    </div>

                    <div class="panel-body">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                  <th>#</th>
                                  <th>Imagen</th>
                                  <th>Producto</th>
                                  <th>Proveedor</th>
                                  <th class="text-center">Precio</th>
                                  <th class="text-center">Cantidad</th>
                                  <th class="text-center">SubTotal</th>
                                  <th class="text-center">Eliminar</th>
                                </tr>
                                @foreach($carrito as $item)
                                <tr>
                                  <!-- <td>{{$loop->iteration}}</td> -->
                                  <td>{{$item->id}}</td>
                                  <td>
                                  <a href="#" onclick="mostrarImagen('{{asset('imagenes/productos/'.$item->imagen)}}', '{{$item->descripcion}}')" >
                                  <img src="{{asset('imagenes/productos/'.$item->imagen)}}" class="img-circle img-bordered-xs" style="height: 40px; width: 40px;" alt="{{$item->nombre}}">
                                  </a>
                                  </td>
                                  <td>{{$item->nombre}}</td>
                                  <td><code style="color: blue;"> <i class="fa fa-home"></i> {{$item->nombre_comercial}} </code></td>
                                  <td class="text-center">{{ number_format($item->precio,2) }}</td>
                                  <td class="text-center">                                                
                                      <div class="input-group">
                                        <input type="number" step="1" name="" value="{{$item->cantidad}}" id="cant-{{$item->id}}" max="{{$item->cantDisponible}}" min="1" style="width: 3em;">
                                        <button class="btn btn-xs btn-success" onclick="edit_carrito('{{route('carrito.editar', array($item->id, ':cant'))}}', '{{ $item->id }}')"><i class=" fa fa-retweet"></i></button>
                                      </div>                                      
                                  </td>
                                  <td class="text-center">{{ number_format($item->precio * $item->cantidad,2) }}</td>
                                  <!-- <td><a href="#" class="btn btn-danger btn-sm"><i class="fa fa-remove"></a></td> -->
                                  <td class="text-center">
                                    <button onclick="eliminar('{{route('carrito.eliminar', $item->id)}}')" class="btn btn-warning btn-sm">x</button>
                                  </td>
                                @endforeach
                                <tr style="font-size: 15px;">
                                    <td colspan="3"><strong>Sub Total</strong></td>
                                    <td><strong>Nº de Proveedores {{ $cantProveedores }}</strong></td>
                                    <td></td>
                                    <td class="text-center"><strong>#{{ $cantProductos }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($subTotal,2) }}</strong></td>
                                    <td class="text-center">
                                        <button onclick="eliminar('{{route('carrito.vaciar')}}')" class="btn btn-danger btn-sm">X</button>
                                    </td>
                                </tr>
                                <tr style="font-size: 20px;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                    <td class="text-center" colspan="2"><strong>Total a pagar:</strong></td>
                                    <td class="text-center" colspan="2"><strong> {{ number_format($total,2) }}</strong></td>
                                    
                                </tr>
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
function eliminar(urli)
{ 

  $.confirm({
      title: 'Eliminar Carrito',
      content: 'Esta seguro de realiar la acción ?',
      icon: 'fa  fa-thumbs-o-down',
      animation: 'scale',
      closeAnimation: 'scale',
      opacity: 0.5,
      type: 'red',
      buttons: {
          'confirm': {
              text: 'SI',
              btnClass: 'btn-blue',
              action: function () {
                 $.ajax({
                  method: 'get',
                  url: urli,
                  success: function(result)
                  {
                      location.reload();
                      // document.getElementById('label-carrito-cant').innerHTML = 'Carrito('+ result + ')';
                      console.log('cantidad de productos en el carrito: '+result);
                  },
                  error: function(){
                     
                      $.alert({
                            title: 'Error.!',
                            content: 'Ups. Algo salio mal en su carrito.',
                            icon: 'fa fa-info',
                            animation: 'scale',
                            closeAnimation: 'scale',
                            buttons: {
                                okay: {
                                    text: 'OK',
                                    btnClass: 'btn-blue'
                                }
                            }
                        });
                  },

              });
                  
              }
          },
          'cancel': {
              text: 'Cancelar',
          },
      }
  });
}
function mostrarImagen(urli, descripcion)
{
  // alert(urli);
    $.alert({
      title: '',
      content: '<img class="img-responsive" width=100% src="'+urli+'"> <br> <p>'+descripcion+'</p>',
      escapeKey: true,
      columnClass: 'col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6',
      closeIcon: true,
      theme: 'supervan',
  });
}
function edit_carrito(urli, id)
{
  // alert(urli);
  var cant = document.getElementById('cant-'+id).value;
  urli = urli.replace(':cant', cant);
  // alert(urli);
  $.ajax({
    method: 'get',
    url: urli,
    success: function(result)
    {
      // alert('ok');
      location.reload();
    },
    error: function()
    {
      $.alert({
          title: 'Error.!',
          content: 'Ups. Algo salio mal en tu carrito',
          icon: 'fa fa-info',
          animation: 'scale',
          closeAnimation: 'scale',
          type: 'red',
          buttons: {
              okay: {
                  text: 'OK',
                  btnClass: 'btn-red'
              }
          }
      });
    },
  });
}
</script>
@endsection

