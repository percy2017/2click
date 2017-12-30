
@extends('backend.layouts.app')
@section('mystyle')
@endsection
@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
    <div class="container">
        <div class="row">
            <form method="post" action="{{route('proveedores.store')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="col-xs-12">
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4>
                                    <span class="glyphicon glyphicon-cutlery"></span> Nuevo Negocio
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Enviar</button>
                                        <a href="{{ URL::previous() }}" class="btn btn-danger"><span class="fa fa-reply"></span> Cancelar</a>
                                    </div>
                                </h4>
                            </div>

                            <div class="panel-body">
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="form-group">
                                        <label>Tipo de Negocio</label>
                                        <select name="tipo_id" class="form-control">
                                            @foreach($tipos as $item)
                                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre Comercial</label>
                                        <input type="text" class="form-control" name="nombre_comercial" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Direccion</label>
                                        <input type="direccion" class="form-control" id="direccion" name="direccion" required>
                                    </div>
                                    <div class="form-group">
                                        <label>whatsapp o movil</label>
                                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" required>
                                    </div>
                                    <div class="form-group">
                                         <label>Logo</label>
                                        <input type="file" id="logo" name="logo">
                                        <!-- <p class="help-block">Logo del Negocio</p> -->
                                
                                    </div>
                                    <div class="form-group">
                                         <label>Habilitado</label>
                                         <div class="checkbox">
                                             <input name="habilitado" type="checkbox" data-size="small" data-toggle="toggle" data-on="SI" data-off="NO" checked="true">
                                         </div>                                    
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-5 col-xs-12 text-center">
                                    <!-- <label>Ubicacion Geografica</label> -->
                                     
                                    <div id="cargando_map" class="text-center">
                                        <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
                                    </div>
                                    <div id="cargado_map" class="text-center" style="display: none;">
                                        <label>Agarre y arrastre el marcador para mejorar su ubicacion!</label>
                                        <div id="map" style="width: 100%; height: 300px;"></div>
                                        <input type="text" id="latitud" name="latitud" hidden="false">
                                        <input type="text" id="longitud" name="longitud" hidden="false">
                                        <div class="input-group">
                                          <input type="search" id="buscar_mapa" class="form-control" placeholder="Encuentra tu localidad.. (Ejemplo: Trinidad, Beni)">
                                          <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="buscarMapa()" type="button">Ir</button>
                                          </span>
                                        </div><!-- /input-group -->
                                        
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

