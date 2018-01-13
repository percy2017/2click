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
                                    <h3>
                                          Panel de Principal
                                    </h3>
                              
                              </div>
                              <div class="panel-body">  
                                    <div class="row">
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group text-center" style="border-style: ridge; height: 300px; background-color: #EEEEEE;">
                                                      <h1>{{ config('app.name') }}</h1>
                                                      <hr>
                                                      <h4>Hola, {{ Auth::user()->name}} bienvenido a {{ config('app.name') }} un servicio delivery. Desde aqui podras administrar tu negocios, productos y solicitudes</h4>
                                                      <!-- <p></p> -->
                                                      <hr>
                                                      <a class="btn btn-primary btn-md" href="{{ route('productos.index') }}">
                                                           <i class="fa fa-list"></i> Mis Productos
                                                      </a>
                                                      <a class="btn btn-primary btn-md" href="{{ route('solicitudes.index') }}">
                                                           <i class="fa fa-shopping-cart"></i> Solicitudes
                                                      </a>
                                                </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                                <video width="100%" height="300px" controls>
                                                      <source src="{{ asset('videos/spot.mp4') }}" type="video/mp4">
                                                      <!-- <source src="movie.ogg" type="video/ogg"> -->
                                                      Your browser does not support the video tag.
                                                </video>
                                          </div>
                                    </div>  
                                    <div class="row">
                                          <div class="col-sm-4 col-md-4 col-xs-12">
                                                <div class="thumbnail">
                                                      <img src="{{ asset('imagenes/2click/logo.jpg') }}" alt="logo" class="img-responsive img-thumbnail" style="height: 250px; width: 100%;">
                                                      
                                                      <div class="caption">
                                                            <h3 class="text-center"> <u>Quienes somos</u></h3>
                                                            <label class="text-justify">
                                                                  {{ config('app.name') }}, es un servicio de pedidos a domicilio (delivery), que te brinda de una herramienta tecnologica y una logistica de transporte, para automatizar y  optimizar las ventas de tus productos.
                                                            </label>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-sm-4 col-md-4 col-xs-12">
                                                <div class="thumbnail">
                                                      <img src="{{ asset('imagenes/2click/web-responsive.png') }}" alt="logo" class="img-responsive img-thumbnail" style="height: 250px; width: 100%;">
                                                      
                                                      <div class="caption">
                                                            <h3 class="text-center">
                                                                  <u>Plataforma Web</u>
                                                            </h3>
                                                            <label class="text-justify">
                                                                  {{ config('app.name') }}, te brinda de una herramienta web responsive, multiplataforma, intitutiva e inteligente basado en mapas, para que administres todos tus negocios, productos y solicitudes de tus clientes.
                                                            </label>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-sm-4 col-md-4 col-xs-12">
                                                <div class="thumbnail">
                                                      <img src="{{ asset('imagenes/2click/logistica.jpg') }}" alt="logo" class="img-responsive img-thumbnail" style="height: 250px; width: 100%;">
                                                      
                                                      <div class="caption">
                                                            <h3 class="text-center">
                                                                  <u>Logistica y Transporte</u>
                                                            </h3>
                                                            <label class="text-justify">
                                                                  {{ config('app.name') }}, pone a tu dispocicion toda la logistica necesaria para el transporte de tus productos. para que tu te concentres en lo importante, que es ofrecer productos de calidad.
                                                            </label>
                                                      </div>
                                                </div>
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
</script>
@endsection
