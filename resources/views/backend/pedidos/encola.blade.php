@extends('backend.layouts.app')
@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
@include('backend.pedidos.productos_modal')
@include('backend.pedidos.mensajero_modal')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        
                        <h3>
                            <i class="fa fa-shopping-cart"></i>
                            Pedidos en Cola
                            <div class="pull-right">
                                <a href="{{ route('pedidos.historico') }}" class="btn btn-sm btn-default"><i class="fa fa-clock-o"></i> Historico</a>
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
                                        <th>Cliente</th>
                                        <th>Direccion</th>
                                        <th>Estado</th>
                                        <th>Pago</th>
                                        <th>Cupon</th>
                                        <th>Total</th>  
                                        <!-- <th>Imagen</th> -->
                                        <th>Actualizado</th>
                                        <th class="text-center">Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($pedidos as $item)
                                    <tr>                                 
                                        <td>{{$item->id}}</th>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                        <td><a href="#" onclick="mostrar_imagen('{{ asset('imagenes/users/'.$item->foto) }}')"> {{ $item->name }} </a></td>
                                        <td>{{ $item->direccion }}</td>
                                        <td><u>{{ $item->estado }}</u></td>
                                        <td><u>{{ $item->pago }}</u></td>
                                        <td><u>{{ $item->cupon }}</u></td>
                                        <td>{{ number_format($item->total,2) }}</td>
                                        <!-- <td>{{ $item->imagen }}</td> -->
                                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#productos_modal" onclick="carrito('{{ route('pedidos.carrito',$item->id) }}')">
                                                <i class="fa fa-list"></i>Productos
                                            </button>
                                            <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#mensajero_modal" onclick="mensajero('{{ route('pedidos.mensajero',$item->id) }}','{{ route('pedidos.mensajeros_all') }}', '{{ route('pedidos.asignar',array(':mensajero_id', $item->id)) }}')">
                                                <i class="fa fa-location-arrow"></i>Mensajero
                                            </button>
                                            <button class="btn btn-xs btn-default" onclick="cancelar('{{ route('pedidos.cancelar',$item->id) }}')">
                                                <i class="fa fa-trash"></i>
                                                Cancelar
                                            </button>
                                        </td>

                                    </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                    <div class="panel-footer text-center">
                        {{$pedidos->links()}}
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
    function mostrar_imagen(imagen)
    {
        // alert(imagen);
        $.alert({
            title:'',
            content: '<img class="img-responsive" width=100% src="'+imagen+'">',
            escapeKey: 'close',
            theme: 'supervan',
            buttons: {
                close: function()
                {

                }
            }
        });
    }
    function mensajero(urli, mensajeros, asignar_mensajero)
    {

        // alert(urli);
        document.getElementById('cargando_mensajero').style.display = 'block';
        document.getElementById('mensajero_detalle').style.display = 'none';
        document.getElementById('mensajero_detalle').innerHTML = '';
        document.getElementById('mensajero_all').innerHTML = '';

        $.ajax({
            url: urli,
            type: 'GET',
            dataType: 'json',
            // data: {param1: 'value1'},
        })
        .done(function(result) {

            // console.log(result);
            if(result.length > 0)
            {
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
                // var cadena2 ='';
                // alert(mensajeros);
                $.ajax({
                    url: mensajeros,
                    type: 'GET',
                    dataType: 'json',
                    data: {param1: 'value1'},
                })
                .done(function(result) {
                    // cadena = '<select class="form-control myselector">';
                    cadena = '<div class="text-center"><label>Elije un mensajero: </label> <br>';
                    for(var i = 0 ; i < result.length; i++)
                    {
                        // cadena += '<option value="">'+result[i].name+' - '+result[i].alias+'</option>';
                        url_asignar = asignar_mensajero.replace(':mensajero_id', result[i].mensajero_id);
                        cadena += '<a href="'+url_asignar+'">'+result[i].mensajero_id+' - '+result[i].name+' - '+result[i].alias+'</a><br>';
                    }
                    // cadena += '</select>';
                    // console.log("success");
                    cadena += '</div>';
                    document.getElementById('mensajero_detalle').innerHTML = 'Pedido sin mensajero';
                    document.getElementById('mensajero_all').innerHTML = cadena;
                // console.log(cadena);
                })
                .fail(function() {
                    console.log("error en traer los mensajero del servidor");
                })
                .always(function() {
                    // console.log("complete");
                });
                

            }   
            
            document.getElementById('cargando_mensajero').style.display = 'none';
            document.getElementById('mensajero_detalle').style.display = 'block';
        })
        .fail(function() {
            console.log("error en obtener los mensajero asignados");
        })
        .always(function() {
            // console.log("complete");
        });
        
    }
    function carrito(urli)
    {
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
                cadena +='<th>Producto</th>';
                cadena +='<th>Entregado</th>';
                cadena +='<th>Precio</th>';
                cadena +='<th>Cantidad</th>';
                cadena +='<th>Negocio</th>';
                cadena +='<th>Representante</th>';
                cadena +='<th>Direccion</th>';
                 cadena +='<th>Whatsapp</th>';
                cadena +='</tr></thead><tbody>';
            for (var i = 0; i < result.length; i++) 
            {
                cadena+='<tr><th>'+result[i].id+'</th>';
                cadena+='<th>'+result[i].nombre+'</th>';
                if(result[i].entregado == 1)
                {
                    cadena+='<th><input type="checkbox" checked></th>';

                }else
                {
                    cadena+='<th><input type="checkbox"></th>';
                }
                
                cadena+='<th>'+result[i].precio+'</th>';
                cadena+='<th>'+result[i].cantidad+'</th>';
                cadena+='<th><a href="#">'+result[i].nombre_comercial+'</a></th>';
                cadena+='<th><a href="#">'+result[i].name+'</a></th>';
                cadena+='<th>'+result[i].direccion+'</th>';
                cadena+='<th><a target="_blank" href="https://api.whatsapp.com/send?phone='+result[i].whatsapp+'&text=Buenos dias, '+result[i].nombre_comercial+'. Tienes un producto para entregar - '+result[i].nombre+' - Cant#'+result[i].cantidad+', Date prisa el mensajero esta de ida a recojer.">'+result[i].whatsapp+'</a></th></tr>';
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
    function cancelar(urli)
    {
        // alert(urli);
        $.confirm({
            escapeKey: 'cancel',
            title: 'Cancelar',
            content: 'Estas seguro de cancelar el pedido?',
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
