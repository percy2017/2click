@extends('backend.layouts.app')
@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
    @include('backend.pedidos.mensajero_modal')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        
                        <h3>
                            <i class="fa fa-shopping-cart"></i>
                            Solicitudes en Cola
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
                                        <th>Solicitado</th>
                                        <!-- <th>Imagen</th> -->
                                        <th class="text-center">Pedido#</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th class="text-center">Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($solicitudes as $item)
                                    <tr>                                 
                                        <td>{{$item->id}}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                        <td class="text-center">{{ $item->pedido_id }}</td>
                                        <td><a href="#" onclick="mostrar_imagen('{{asset('imagenes/productos/'.$item->imagen)}}','{{ $item->descripcion }}')">{{ $item->nombre }}</a></td>
                                        <td>{{ number_format($item->precio,2) }}</td>
                                        <td>{{ number_format($item->cantidad,2) }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#mensajero_modal" onclick="mensajero('{{ route('solicitudes.mensajero',$item->pedido_id) }}')">
                                                <i class="fa fa-location-arrow"></i>
                                                Mensajero
                                            </button>
                                            
                                            @if(App\Envio::where('pedido_id', $item->pedido_id)->first())
                                                <button class="btn btn-info btn-xs" onclick="entregar('{{ route('solicitudes.entregar', array($item->id, $item->pedido_id)) }}')">
                                                <i class="fa fa-thumbs-o-up"></i>
                                                Entregar
                                                </button>
                                            @else
                                                <button class="btn btn-info btn-xs" onclick="entregar('{{ route('solicitudes.entregar', array($item->id, $item->pedido_id)) }}')" disabled>
                                                <i class="fa fa-thumbs-o-up"></i>
                                                Entregar
                                            </button>
                                            @endif
            
                                            
                                        </td>

                                    </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer text-center">
                        {{$solicitudes->links()}}
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
        document.getElementById('mensajero_detalle').innerHTML = '';
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
    function mensajero(urli)
    {

        //alert(urli);
        document.getElementById('cargando_mensajero').style.display = 'block';
        document.getElementById('mensajero_detalle').style.display = 'none';
        $.ajax({
            url: urli,
            type: 'GET',
            dataType: 'json',
            // data: {param1: 'value1'},
        })
        .done(function(result) {

            // console.log(result);
            if(result)
            {
                // console.log(result);
                // var cadena = '<p> Alias : '+result.alias+'</p>';
                // cadena += '<p> Vehiculo : '+result.vehiculo+'</p>';
                // cadena +=  '<p> Ruedas : '+result.ruedas+'</p>';
                // cadena +=  '<p> Asiganado : '+result.created_at+'</p>';
                // document.getElementById('mensajero_detalle').innerHTML = cadena;
                var cadena = '';
                for(var i = 0 ; i < result.length; i++)
                {
                    cadena += '<p> Alias : '+result[i].alias+'</p>';
                    cadena += '<p> Nombre : '+result[i].name+'</p>';
                    cadena += '<p> Vehiculo : '+result[i].vehiculo+'</p>';
                    cadena +=  '<p> Ruedas : '+result[i].ruedas+'</p>';
                    cadena +=  '<p> Asignado : '+result[i].created_at+'</p><hr>';
                }
                document.getElementById('mensajero_detalle').innerHTML = cadena;
            }else
            {   
                document.getElementById('mensajero_detalle').innerHTML = 'Solicitud a un sin mensajero. En proceso de Asignacion.';
            }   
            
            document.getElementById('cargando_mensajero').style.display = 'none';
            document.getElementById('mensajero_detalle').style.display = 'block';
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    }

    function entregar(urli) 
    {
        // alert(urli);
        $.confirm({
            escapeKey: 'cancel',
            title: 'Entregaste el producto?',
            content: 'Dale click en SI, si entregaste el producto al mensajero.',
            buttons: {
                formSubmit: {
                    text: 'SI',
                    btnClass: 'btn-blue',
                    action: function () 
                    {
                         $.ajax({
                            method: 'get',
                            url: urli,
                            success: function(result)
                            {
                                location.reload();
                            },
                            error: function(){
                               
                                $.alert({
                                      title: 'Error.!',
                                      content: 'Ups. Algo salio mal.',
                                      icon: 'fa fa-info',
                                      animation: 'scale',
                                      type: 'red',
                                      closeAnimation: 'scale',
                                      buttons: {
                                          okay: {
                                              text: 'OK',
                                              btnClass: 'btnClass-blue'
                                          }
                                      }
                                  });
                            },

                        });  
                         
                    }
                },
                cancel: function () 
                {
                    //close
                },
            },
            onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
        });
    }
</script>
@endsection
