@extends('backend.layouts.app')

@section('mystyle')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
<link href="{{ asset('plugins/file-input/fileinput.css') }}" rel="stylesheet">
@endsection
@section('content')

 <div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
    <div class="container">
    <div class="row">
        <form method="post" action="{{route('productos.store')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="col-xs-12">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                <span class="glyphicon glyphicon-list-alt"></span> Nuevo Producto
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Enviar</button>
                                    <a href="{{ URL::previous() }}" class="btn btn-danger"><span class="fa fa-reply"></span> Cancelar</a>
                                </div>
                            </h3>
                        </div>

                        <div class="panel-body">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="form-group">
                                    <label>Categoria</label>
                                        <select name="categoria_id" id="" class="form-control myselector">
                                            @foreach($categorias as $item)
                                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label>Negocio</label>
                                        <select name="proveedor_id" id="" class="form-control myselector">
                                            @foreach($negocios as $item)
                                                <option value="{{$item->id}}">{{$item->nombre_comercial}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
                                </div>
                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <textarea class="form-control" name="descripcion" id="" rows="4" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Precio</label>
                                    <input type="number" class="form-control" name="precio" placeholder="Precio" required>
                                </div>
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" class="form-control" name="cantidad" placeholder="Cantidad" required>
                                </div>
                                
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                     <label>Imagen</label>
                                    <input name="imagen" id="file-1" type="file" class="file">
                                </div>
                                <div class="form-group">
                                     <label>Habilitado</label>
                                     <div class="checkbox">
                                         <input name="habilitado" type="checkbox" data-size="small" data-toggle="toggle" data-on="SI" data-off="NO" checked="true">
                                     </div>                                    
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(document).ready(function() 
    {
        $('.myselector').select2();
    });
    document.getElementById('cargando').style.display = 'none';
    document.getElementById('cargado').style.display = 'block';
</script>
<script src="{{ asset('plugins/file-input/fileinput.js') }}"></script>
<script>
    $("#file-1").fileinput({
    uploadUrl: "#", // server upload action
    // uploadAsync: true,
    // maxFileCount: 5,
    showBrowse: false,
    showUpload: false,
    showLentgh: false,
    browseOnZoneClick: true,
    dropZoneTitle: 'Imagen',
    dropZoneClickTitle: '<br> 282x248',
    initialPreview: [
        document.getElementById('file-1').value,
    ],
    initialPreviewConfig: [
        {caption: "Imagen"},
    ],
    initialPreviewAsData: true,
    });
</script>
@endsection
