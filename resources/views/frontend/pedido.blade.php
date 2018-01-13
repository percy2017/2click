@extends('frontend.layouts.app')
@section('mystyle')

@endsection
@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
    <p>{{ config('app.mensaje_cargando') }}</p>
</div>
<div id="cargado" style="display:none;">
@include('frontend.mapas.create')
    <div class="container">
        <div class="row">
          <form id="pedidoForm" action="{{ route('pedido.guardar') }}" method="POST">
          {{ csrf_field() }}
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                          <i class="fa fa-shopping-cart"></i>
                            Datos del Pedido
                            <div class="pull-right">
                                <button type="button" onclick="pedir('{{ route('pedido.guardar') }}','{{ asset('imagenes/2click/gracias.jpg') }}','{{ route('perfil') }}')" class="btn btn-primary"><span class="fa fa-share-alt"></span> Pedir</button>
                                <a href="{{ URL::previous() }}" class="btn btn-danger"> <i class="fa fa-reply"></i> Atras</a>
                                
                            </div>
                        </h4>
                    </div>

                    <div class="panel-body">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <h4>
                                <u>Datos del Cliente</u>
                            </h4>
                            <div class="form-group text-center">
                              <img class="img-responsive img-thumbnail" src="{{ asset('imagenes/users/'.auth::user()->foto) }}" alt="" />
                            </div>
                            <div class="form-group">
                              <label for="">Nombre: </label>
                              <br>
                              {{ Auth::user()->name }}                    
                            </div>
                            <div class="form-group">
                              <label for="">Correo: </label>
                              <br>
                              {{ Auth::user()->email }}                    
                            </div>
                            <div class="form-group">
                              <label for="">Whatsapp: </label>
                              <br>
                              {{ Auth::user()->whatsapp }}                    
                            </div>
                            <div class="form-group">
                              <label for="">Carnet o Nit: </label>
                              <br>
                              {{ Auth::user()->carnet }}
                            </div>
                            <div>
                              <label for="">Vives en: </label>
                              <br>
                              {{ App\Localidad::where('id',Auth::user()->localidad_id)->first()->nombre }}                          
                            </div>    
                          <hr>                        
                      </div>
                      
                      
                       <div class="col-md-10 col-sm-10 col-xs-12">
                           <h4>
                               <u>Lugar para la entrega</u> 
                           </h4>
                           <div class="form-group">
                                <div class="input-group">
                                  <select name="lugar_id" id="" class="form-control myselector" required>
                                        @foreach($lugares as $item)
                                            <option value="{{$item->id}}">{{$item->direccion}}</option>
                                        @endforeach
                                    </select>
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" data-toggle="modal" data-target="#modal_mapa_create" type="button" onclick="cargar_mapa()"><i class="fa fa-map-marker"></i>Nuevo</button>
                                  </span>

                                </div><!-- /input-group -->
                                <p>Selecciona la ubicacion donde recibirás tu pedido. pudes agragar cuantos quieras.</p>
                            </div>
                            <h4>
                              <u>Metodo de Pago</u>
                            </h4>
                            <div class="form-group">
                               <select name="pago_id" id="" class="form-control myselector">
                                    @foreach($pagos as $item)
                                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                                <p>Selecciona el metodo de pago.</p>
                            </div>
                            <h4>
                               <u>Detalle del pedido</u> 
                           </h4>
                           <div class="form-group">
                            Cantidad de Productos:
                            <label for=""> {{ $cantProductos }} </label>
                            <br>
                            Cantidad de Proveedores: 
                            <label for="">{{ $cantProveedores }}</label>
                            <br>
                            Total a Pagar:
                            <label for="">{{ $total }} Bs.</label>
                           </div>
                            @if($cupon)
                              <div class="form-group">
                                <h4>
                                  <u>Tienes un Cupon ?</u>
                                </h4>
                                
                                <div class="input-group">
                                  <input type="text" name="codigo" class="form-control" placeholder="ingresa el codigo del cupon aqui..">
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" data-toggle="modal" data-target="#modal_mapa_create" type="button"><i class="glyphicon glyphicon-piggy-bank"></i>Validar</button>
                                  </span>

                                </div>
                              </div>
                            @endif
                            <h4>
                              <u>Pronto podras pagar con</u> 
                            </h4>
                            <div class="form-group">
                              <p>
                                <img src="{{asset('imagenes/credit/visa.png')}}" alt="Visa">
                                <img src="{{asset('imagenes/credit/american-express.png')}}" alt="Visa">
                                <!-- <img src="{{asset('imagenes/credit/cirrus.png')}}" alt="Visa"> -->
                                <img src="{{asset('imagenes/credit/mastercard.png')}}" alt="Visa">
                                <!-- <img src="{{asset('imagenes/credit/mestro.png')}}" alt="Visa"> -->
                                <!-- <img src="{{asset('imagenes/credit/paypal.png')}}" alt="Visa"> -->
                                <img src="{{asset('imagenes/credit/paypal2.png')}}" alt="Visa">
                              </p>
                            </div>
                           
                            
                       </div>
                        
                    </div>
                    <div class="panel-footer text-center">
                        {{ config('app.myfooter') }}
                    </div>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>
@endsection
@section('myscript')
<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.api_google_maps')}}"></script>
<script src="{{ asset('js/mapa.js') }}"></script>
<script>
    $(document).ready(function() 
    {
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
    });
    function cargar_mapa()
    {
      initMap();
    }
    function pedir(urli, imagen, vista)
    {
      $.confirm({
            escapeKey: 'cancel',
            title: 'Pedir',
            content: 'Estas seguro de completar el pedido?',
            buttons: {
                formSubmit: {
                    text: 'SI',
                    btnClass: 'btn-blue',
                    action: function () 
                    {
                      var miform = $('#pedidoForm');
                      var data = miform.serialize();
                      $.ajax({
                          method: 'post',
                          url: urli,
                          data: data,
                          success: function(result)
                          {
                            $.alert({
                              title: 'Solicitud Enviada',
                              content: '<img class="img-responsive" width=100% src="'+imagen+'"> <br>  <h4 class="text-center" ><code style="color: blue;"> Tu pedido se esta procesando, tiempo para la entrega '+'{{ config('app.tiempo_aprox_entrega') }}'+'</code> </h4>',
                              buttons: {
                                  'Aceptar': {
                                    action: function () {
                                       location.href= vista;
                                    }    
                                  }
                              }
                            });
                          },
                          error: function(){
                             
                              $.alert({
                                    title: 'Error.!',
                                    content: 'Ups. Algo salio mal. - (Seleccione un lugar de entrega.)',
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

