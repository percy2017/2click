@extends('frontend.layouts.app')
@section('mystyle')

@endsection
@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
@include('frontend.mapas.create')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            Datos del Pedido
                            <div class="pull-right">
                                <a href="{{ route('pedido.enviar') }}" class="btn btn-primary"><span class="glyphicon glyphicon-share-alt"></span> Pedir</a>
                                <a href="{{ URL::previous() }}" class="btn btn-danger"> <i class="fa fa-reply"></i> Atras</a>
                                
                            </div>
                        </h4>
                    </div>

                    <div class="panel-body">
                       <div class="col-md-4 col-sm-3 col-xs-12">
                            <h4>
                                <u>Datos del Cliente</u>
                            </h4>
                            <div class="">
                            <img class="img-responsive img-thumbnail" style="width: 70%; height: 150px;" src="{{ asset('imagenes/users/'.auth::user()->foto) }}" alt="" />
                            </div>
                            <br>                             
                          <label>{{ Auth::user()->name }} <span class="glyphicon glyphicon-user"></span> </label>
                          <br>
                          <label>{{ Auth::user()->email }} <span class="glyphicon glyphicon-exclamation-sign"></span> </label>
                          <br>
                          <label>{{ Auth::user()->whatsapp }} <span class="glyphicon glyphicon-phone"></span> </label>
                          <br>
                          <label>{{ Auth::user()->carnet }} <span class="glyphicon glyphicon-credit-card"></span> </label>
                          <br>
                          <label>
                            {{ $rol = App\Localidad::where('id',Auth::user()->localidad_id)->first()->nombre }} <span class="glyphicon glyphicon-map-marker"></span> 
                          </label>
                            
                       </div>
                       <div class="col-md-8 col-sm-9 col-xs-12">
                           <h4>
                               <u>Ubicacion para la entrega</u> 
                           </h4>
                           <div class="form-group">
                                <div class="input-group">
                                  <select name="categoria_id" id="" class="form-control myselector">
                                        @foreach($lugares as $item)
                                            <option value="{{$item->id}}">{{$item->direccion}}</option>
                                        @endforeach
                                    </select>
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" data-toggle="modal" data-target="#modal_mapa_create" type="button"><i class="glyphicon glyphicon-map-marker"></i>Nuevo</button>
                                  </span>

                                </div><!-- /input-group -->
                                <p>Seleccione el lugar donde recibirás tu pedido</p>
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
                            @if($cupon)
                              <div class="form-group">
                                <h4>
                                  <u>Tines un Cupon ?</u>
                                </h4>
                                <input type="text" name="codigo" class="form-control" placeholder="ingresa el codigo del cupon aqui..">
                              </div>
                            @endif
                            
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuQDYx7yXuhVf7kAV_NMPvJP7y3R_gHws&callback=initMap" async defer></script>
<script src="{{ asset('js/mapa.js') }}"></script>
<script>
    $(document).ready(function() 
    {
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
        
    });

</script>

@endsection

