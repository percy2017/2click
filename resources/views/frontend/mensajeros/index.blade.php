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
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                          <i class="fa fa-shopping-cart"></i>
                            Pedidos en cola
                            <div class="pull-right">
                                <a href="{{ route('mensajero.historico') }}" class="btn btn-default">
                                    <i class="fa fa-clock-o"> Historico</i>
                                </a>

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
                                  
                                  <td><a href="#" onclick="mostrar_imagen('{{asset('imagenes/users/'.$item->foto)}}')">{{ $item->name }}</td>
                                  <td>{{ $item->destino }}</a></td>
                                  <td class="text-center">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#productos_modal" onclick="carrito('{{ route('mensajero.productos',$item->id) }}')">
                                                <i class="fa fa-list"></i> Productos
                                            </button>
                                    <button onclick="asignar('{{ route('mensajero.asignar',$item->id) }}','{{ route('mensajero.mapa',$item->id) }}')" class="btn btn-default btn-sm"><i class="fa fa-money"></i> Tomarlo</button>
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
    function asignar(urli, url_mapa)
    {
        // alert(urli);
        $.confirm({
            escapeKey: 'cancel',
            title: 'Asignar',
            content: 'Estas seguro de tomar el pedido?',
            cancelButtonClass: 'btn-danger',
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
                                // console.log('cantidad de productos en el carrito: '+result);
                                // cant_carrito();
                                location.href = url_mapa;
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
                    // text: 'NO';
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
    function carrito(urli)
    {
      // alert(urli);
        document.getElementById('cargando_carrito').style.display = 'block';
        document.getElementById('tabla_carrito').style.display = 'none';
        var subTotal=0;
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
                // cadena +='<th>#</th>';
                cadena +='<th>Cant</th>';
                cadena +='<th>Productos</th>';
                
                cadena +='<th>Negocio</th>';
                cadena +='<th>Destino</th>';
                cadena +='</tr></thead><tbody>';
            for (var i = 0; i < result.length; i++) 
            {
                // cadena+='<tr><th>'+result[i].id+'</th>';
                cadena+='<tr><th>'+result[i].cantidad+'</th>';
                cadena+='<th> <a href="#">'+result[i].nombre+'</a></th>';
                
                cadena+='<th><a href="#">'+result[i].nombre_comercial+'</a></th>';
                cadena+='<th>'+result[i].direccion+'</th>';
                subTotal += result[i].cantidad;
            }
                // cadena+='<tr><th></th>';
                cadena+='<tr><th colspan="4" >Cantidad de productos: '+subTotal+' - Cantidad de Items: '+result.length+'</th></tr>';
            cadena +='</tbody></table></div>';
            document.getElementById('tabla_carrito').innerHTML = cadena;
            document.getElementById('cargando_carrito').style.display = 'none';
            document.getElementById('tabla_carrito').style.display = 'block';
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

