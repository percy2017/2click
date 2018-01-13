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
        <form method="post" action="{{route('mensajeros.store')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="col-xs-12">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                <span class="fa fa-list-alt"></span> Nuevo Mensajero
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Guardar</button>
                                    <a href="{{ URL::previous() }}" class="btn btn-danger"><span class="fa fa-reply"></span> Cancelar</a>
                                </div>
                            </h3>
                        </div>

                        <div class="panel-body">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="form-group">
                                    <label>Usuario</label>
                                        <select name="user_id" class="form-control myselector">
                                            @foreach($users as $item)
                                                <option value="{{$item->id}}">{{$item->name}} - {{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label>Vehiculo</label>
                                        <select name="vehiculo_id" class="form-control myselector">
                                            @foreach($vehiculos as $item)
                                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label>Alias</label>
                                    <input type="text" class="form-control" name="alias" placeholder="Alias" required>
                                </div>
                                <div class="form-group">
                                     <label>Habilitado</label>
                                     <div class="checkbox">
                                         <input name="habilitado" type="checkbox" data-size="small" data-toggle="toggle" data-on="SI" data-off="NO" checked="true">
                                     </div>                                    
                                </div>
                                
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                     <label>Imagen Permiso</label>
                                    <input name="imagen_permiso" id="file-1" type="file" class="file">
                                </div>
                                <div class="form-group">
                                     <label>Imagen Placa</label>
                                    <input name="imagen_placa" id="file-2" type="file" class="file">
                                </div>
                                <div class="form-group">
                                     <label>Imagen Inspeccion</label>
                                    <input name="imagen_inspeccion" id="file-3" type="file" class="file">
                                </div>
                                <div class="form-group">
                                     <label>Imagen Soat</label>
                                    <input name="imagen_soat" id="file-4" type="file" class="file">
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
<script>
    $(document).ready(function() 
    {
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
        $('.myselector').select2();

    });
    // $("#file-1").fileinput({
    //     uploadUrl: "#", // server upload action
    //     // uploadAsync: true,
    //     // maxFileCount: 5,
    //     showBrowse: false,
    //     showUpload: false,
    //     showLentgh: false,
    //     browseOnZoneClick: true,
    //     dropZoneTitle: 'Imagen',
    //     dropZoneClickTitle: '<br> 282x248',
    //     initialPreview: [
    //         document.getElementById('file-1').value,
    //     ],
    //     initialPreviewConfig: [
    //         {caption: "Imagen"},
    //     ],
    //     initialPreviewAsData: true,
    // });
</script>
@endsection
