@extends('frontend.layouts.app')
@section('mystyle')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <form class="" method="POST" action="{{ route('guardar') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    
                        <div class="panel-heading">
                            <h4>
                                Registro
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="fa fa-save"></span> Guardar
                                    </button>
                                    <a class="btn btn-danger" href="{{ URL::previous() }}"><i class="fa fa-reply"></i> Atras</a>
                                </div>
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">Nombre</label>                         
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">Correo</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Direccion</label>
                                    <input id="" type="text" class="form-control" name="direccion" value="{{ old('direccion') }}" required>
                                    @if ($errors->has('direccion'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('direccion') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <label for="" class="control-label">Whatsapp o Movil</label>
                                    <input type="text" class="form-control" name="whatsapp" required>
    
                                    @if ($errors->has('whatsapp'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('whatsapp') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Carnet o Nit</label>
                                    <input type="text" class="form-control" name="carnet" required>
    
                                    @if ($errors->has('carnet'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('carnet') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <!-- <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div> -->
                                <div class="form-group">
                                    <label>Imagen</label>
                                    <input type="file" name="foto" required>
                                    <p>Foto del usuario</p>
                                </div>
                                <div class="form-group">
                                    <label>No Captcha</label>
                                    {!! NoCaptcha::renderJs() !!}
                                    {!! NoCaptcha::display() !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block" style="color: red;">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <div class="form-group text-center">
                                    <label>Ubicacion Geografica</label>
                                    <label>Agarre y arrastre el marcador para mejorar su ubicacion!</label>
                                    <div id="cargando_map" class="text-center">
                                        <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
                                    </div>
                                    <div id="cargado_map" class="text-center" style="display: none;">
                                        <div id="map" style="width: 100%; height: 300px;"></div>
                                    </div>
                                    
                                    <input type="text" id="latitud" name="latitud" hidden="false">
                                    <input type="text" id="longitud" name="longitud" hidden="false">
                                    <div class="input-group">
                                      <input type="search" id="buscar_mapa" class="form-control" placeholder="Encuentra tu localidad.. (Ejemplo: Trinidad, Beni)">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default" onclick="buscarMapa()" type="button">Ir</button>
                                      </span>
                                        </div><!-- /input-group -->
                                </div>

                                <div class="form-group">
                                    <label>Referencias</label>
                                    <select class="form-control" name="referencia_id">
                                        @foreach($referencias as $item)
                                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Donde Vives?</label>
                                    <select class="form-control" name="localidad_id">
                                        @foreach($localidades as $item)
                                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            {{ config('app.myfooter') }}
                        </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

@endsection
@section('myscript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuQDYx7yXuhVf7kAV_NMPvJP7y3R_gHws&callback=initMap"
    async defer></script>
<script src="{{ asset('js/mapa.js') }}"></script>
<script>
    $(document).ready(function() 
    {
        $('.myselector').select2();
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
    });
</script>
@endsection

