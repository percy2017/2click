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
                          <i class="fa fa-map-marker"></i>
                            Pedidos #{{ $pedido->id }}
                            <div class="pull-right">
                                <button class="btn btn-default" data-toggle="modal" data-target="#indicaciones_modal">
                                    <i class="fa fa-map-marker"></i>
                                    Indicaciones    
                                </button>
                                <button class="btn btn-primary" onclick="reiniciar()">
                                    <i class="fa fa-refresh"> Reiniciar</i>
                                </button>
                                <a href="{{ URL::previous() }}" class="btn btn-danger"><i class="fa fa-reply"></i> Atras</a>
                            </div>
                        </h4>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <h4><u>Proveedores</u></h4>
                                <div class="form-group">
                                    <select name="" id="proveedor" class="form-control">
                                        @foreach($proveedores as $item)
                                            <option value="{{ $item->latitud }}, {{ $item->longitud }}"> {{ $item->nombre_comercial }} </option>
                                        @endforeach
                                    </select>
                                    <br>
                                     <!-- <span class="input-group-btn"> -->
                                        <button class="btn btn-default" type="button" onclick="enrutar(document.getElementById('proveedor').value)" )"><i class="fa fa-road"></i>Ruta</button>
                                      <!-- </span> -->
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <h4><u>Destino</u></h4>
                                <div class="form-group">
                                    <label>
                                        <a href="#" onclick="mostrar_imagen('{{asset('imagenes/users/'.$destino->foto)}}','{{ $destino->name }}')">
                                            <p>{{ $destino->direccion }} <br> {{ $destino->name }}</p>
                                        </a>                                    
                                    </label>
                                    <br>
                                    <!-- <span class="input-group-btn"> -->
                                        <button class="btn btn-default" type="button" onclick="enrutar('{{$destino->latitud.', '.$destino->longitud}}')"><i class="fa fa-road"></i>Ruta</button>
                                        @if($pedido->estado_id == 3)
                                            <button class=" btn btn-primary" onclick="entregar('{{ route('mensajero.entregar', $pedido) }}', '{{ route('mensajero.index') }}')">
                                                <i class="fa fa-check-square-o"></i> Entregar
                                            </button>
                                        @endif
                                        
                                    <!-- </span> -->

                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12">
                                <div id="cargando_map" class="text-center">
                                        <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
                                        <p>Opteniendo tu ubiacion y creando el mapa, espere por favor..</p>
                                    </div>
                                    <div id="cargado_map" class="text-center" style="display: none;">
                                        <h4><u>Agarra y arrastra el marcador<i class="fa fa-map-marker"></i>  para mejorar tu ubicacion!</u></h4>
                                        <div id="map" style="width: 100%; height: 600px;"></div>
                                        <input type="text" id="latitud" name="latitud" hidden="false">
                                        <input type="text" id="longitud" name="longitud" hidden="false">
                                        <div class="input-group">
                                          <input type="search" id="buscar_mapa" class="form-control" placeholder="No es tu ubicacion ??, encuentra la tuya.. (Ejemplo: Trinidad, Beni, Av. Bolivar)">
                                          <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="buscarMapa()" type="button">Ir</button>
                                          </span>
                                        </div><!-- /input-group -->
                                         <div id="right-panel"></div>
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.api_google_maps') }}" async defer></script>
<script src="{{ asset('js/mapa_mensajero.js') }}"></script>
<script>
    $(document).ready(function() 
    {
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
        initMap();
    });
    function reiniciar()
    {
        location.reload();   
    }
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
    function entregar(urli, vista)
    {
        //alert(urli);
        console.log(urli);
        $.confirm({
            escapeKey: 'cancel',
            title: 'Entregaste el Pedido ?',
            content: 'Dale click en SI, si lo entregaste.',
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
                                location.href = vista;
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

