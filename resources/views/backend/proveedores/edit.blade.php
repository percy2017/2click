
@extends('backend.layouts.app')
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
            <form method="post" action="{{route('proveedores.update',$proveedor->id)}}" enctype="multipart/form-data">
                
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="col-xs-12">
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4>
                                    <span class="fa fa-edit"></span> Editar Negocio
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Actualizar</button>
                                        <a href="{{ URL::previous() }}" class="btn btn-danger"><span class="fa fa-reply"></span> Cancelar</a>
                                    </div>
                                </h4>
                            </div>

                            <div class="panel-body">
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="form-group">
                                        <label>Tipo de Negocio</label>
                                        <select name="tipo_id" class="form-control myselector">
                                            @foreach($tipos as $item)
                                                @if($item->id == $proveedor->tipo_id)
                                                    <option value="{{ $item->id }}" selected>{{ $item->nombre }}</option>
                                                @else
                                                     <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                @endif
                                               
                                            @endforeach
                                        </select>                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre Comercial</label>
                                        <input type="text" class="form-control" name="nombre_comercial" required value="{{ $proveedor->nombre_comercial }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Direccion</label>
                                        <input type="direccion" class="form-control" id="direccion" name="direccion" required value="{{ $proveedor->direccion }}">
                                    </div>
                                    <div class="form-group">
                                        <label>whatsapp o movil</label>
                                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" required value="{{ $proveedor->whatsapp }}">
                                    </div>
                                    <div class="form-group">
                                         <label>Logo</label>
                                        <input type="file" id="logo" name="logo">
                                        <p class="help-block">
                                            <a href="#" onclick="mostrar_imagen('{{asset('imagenes/proveedores/'.$proveedor->logo)}}')">
                                                Logo del Negocio
                                            </a>
                                            
                                        </p>
                                
                                    </div>
                                    <div class="form-group">
                                         <label>Abierto</label>
                                         <div class="checkbox">
                                            @if($proveedor->habilitado)
                                                <input name="habilitado" type="checkbox" data-size="small" data-toggle="toggle" data-on="SI" data-off="NO" checked>
                                            @else
                                                <input type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-size="small" name="habilitado">
                                            @endif
                                             
                                         </div>                                    
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div id="cargando_map" class="text-center">
                                        <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
                                        <p>Opteniendo tu ubiacion y creando el mapa, espere por favor..</p>
                                    </div>
                                    <div id="cargado_map" class="text-center" style="display: none;">
                                        <label>Agarre y arrastre el marcador para mejorar su ubicacion!</label>
                                        <div id="map" style="width: 100%; height: 300px;"></div>
                                        <input type="text" id="latitud" name="latitud" value="{{ $proveedor->latitud }}" hidden>
                                        <input type="text" id="longitud" name="longitud" value="{{ $proveedor->longitud }}" hidden>
                                        <div class="input-group">
                                          <input type="search" id="buscar_mapa" class="form-control" placeholder="Encuentra tu localidad.. (Ejemplo: Trinidad, Beni)">
                                          <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="buscarMapa()" type="button">Ir</button>
                                          </span>
                                        </div><!-- /input-group -->
                                        
                                    </div>    
                                    <div class="form-group">
                                        <label for="">Horario de Atencion</label>
                                        <textarea class="form-control" name="atencion"  rows="3">{{ $proveedor->atencion }}</textarea>
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.api_google_maps') }}"></script>
<script src="{{ asset('js/mapa.js') }}"></script>
<script>
    $(document).ready(function() 
    {
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
        $('.myselector').select2();
        mapear_edit({{ $proveedor->latitud }}, {{ $proveedor->longitud }});
        
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
</script>
@endsection


