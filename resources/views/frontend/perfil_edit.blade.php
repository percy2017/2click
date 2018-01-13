@extends('frontend.layouts.app')
@section('mystyle')
@endsection
@section('content')

 <div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
    <p>{{ config('app.mensaje_cargando') }}</p>
</div>
<div id="cargado" style="display:none;">
    <div class="container">
    @if(\Session::has('mensaje_info'))
        <div class="alert alert-info alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Info!</strong> {{ \Session::get('mensaje_info') }}
        </div>
    @endif
    <div class="row">
        <form method="post" action="{{ route('perfil.actualizar') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="col-xs-12">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                <span class="fa fa-edit"></span> Editar Perfil
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Actualizar</button>
                                    <a href="{{ URL::previous() }}" class="btn btn-danger"><span class="fa fa-reply"></span> Cancelar</a>
                                </div>
                            </h3>
                        </div>

                        <div class="panel-body">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="form-group">
                                    <label>Localidad    </label>
                                        <select name="localidad_id" class="form-control myselector" required>
                                            @foreach($localidades as $item)
                                                @if(Auth::user()->localidad_id == $item->id)
                                                    <option value="{{$item->id}}" selected>{{$item->nombre}}</option>
                                                @else
                                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                @endif
                                                
                                            @endforeach
                                        </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Whatsapp o movil</label>
                                    <input type="text" class="form-control" name="whatsapp" value="{{ Auth::user()->whatsapp }}" placeholder="+591 70000001" required>
                                </div>
                                <div class="form-group">
                                    <label>Carnet o Nit</label>
                                    <input type="text" class="form-control" name="carnet" value="{{ Auth::user()->carnet }}" placeholder="1000000 BN" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                     <label>Foto</label>
                                    <input name="foto" id="file-1" type="file" class="file">
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
</script>
<script src="{{ asset('plugins/file-input/fileinput.js') }}"></script>
<script>
    $("#file-1").fileinput({
        //uploadUrl: "#",
        showUpload: false,
        showRemove: false,
        // showDrag: false,
        showBrowse: true,
        browseOnZoneClick: true,
        dropZoneTitle: 'Imagen para editar',
        initialPreview: [
            '{{ asset('imagenes/users/'.Auth::user()->foto) }}',
        ],
        initialPreviewConfig: [
            {caption: "{{ Auth::user()->foto }}", size: 576237, width: "10px", url: "/site/file-delete", key: {{Auth::user()->id}}},
        ],
        
        initialPreviewAsData: true,
    });
</script>
@endsection
