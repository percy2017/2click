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
        <form method="post" action="{{route('productos.update',$producto->id)}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
            <div class="col-xs-12">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                <span class="glyphicon glyphicon-edit"></span> Editar Producto
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Actualizar</button>
                                    <a href="{{ URL::previous() }}" class="btn btn-danger"><span class="fa fa-reply"></span> Cancelar</a>
                                </div>
                            </h3>
                        </div>

                        <div class="panel-body">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="form-group">
                                    <label>Categoria</label>
                                        <select name="categoria_id" class="form-control myselector">
                                            @foreach($categorias as $item)
                                                @if($producto->categoria_id == $item->id)
                                                    <option value="{{$item->id}}" selected>{{$item->nombre}}</option>
                                                @else
                                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                @endif
                                                
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label>Negocio</label>
                                        <select name="proveedor_id"class="form-control myselector">
                                            @foreach($negocios as $item)
                                               
                                                @if($producto->negocio_id == $item->id)
                                                    <option value="{{$item->id}}" selected>{{$item->nombre_comercial}}</option>
                                                @else
                                                    <option value="{{$item->id}}">{{$item->nombre_comercial}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" name="nombre" value="{{ $producto->nombre }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <textarea class="form-control" name="descripcion" id="" rows="4" required>{{ $producto->descripcion }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Precio</label>
                                    <input type="number" class="form-control" name="precio" value="{{ $producto->precio }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" class="form-control" name="cantidad" value="{{ $producto->cantidad }}" required>
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
                                         @if($producto->habilitado)
                                                <input name="habilitado" type="checkbox" data-size="small" data-toggle="toggle" data-on="SI" data-off="NO" checked>
                                            @else
                                                <input type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-size="small" name="habilitado">
                                            @endif
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
        uploadUrl: "#",
        showUpload: false,
        showRemove: false,
        // showDrag: false,
        showBrowse: false,
        browseOnZoneClick: true,
        dropZoneTitle: 'Imagen para editar',
        initialPreview: [
            '{{ asset('imagenes/productos/'.$producto->imagen) }}',
        ],
        initialPreviewConfig: [
            {caption: "{{ $producto->imagen }}", size: 576237, width: "10px", url: "/site/file-delete", key: {{$producto->id}}},
        ],
        
        initialPreviewAsData: true,
    });
</script>
@endsection
