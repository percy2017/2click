@extends('frontend.layouts.app')
@section('mystyle')

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
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
                        <h4>
                            Perfil
                            <div class="pull-right">
                                <a href="{{ route('perfil.editar') }}" class="btn btn-primary"><span class="fa fa-edit"></span> Editar</a>
                            </div>
                        </h4>
                    </div>

                    <div class="panel-body">                        
                        <div class="col-md-3 col-sm-5 col-xs-12">
                          <div class="">
                            <img class="img-responsive img-thumbnail" style="width: 80%; height: 200px;" src="{{ asset('imagenes/users/'.auth::user()->foto) }}" alt="" />
                          </div>
                          
                          <br>
                          <div>
                            <label> {{ $rol = App\Rol::where('id',Auth::user()->rol_id)->first()->nombre }} <span class="glyphicon glyphicon-screenshot"></span> </label> 
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
                          
                                
                        </div>
                        <div class="col-md-9 col-sm-7 col-xs-12">
                            <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#pedidos" aria-controls="home" role="tab" data-toggle="tab">Historico de pedidos</a></li>
                            <li role="presentation"><a href="#lugares" aria-controls="profile" role="tab" data-toggle="tab">Lugares de entrega</a></li>
                          </ul>

                          <!-- Tab panes -->
                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="pedidos">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead> 
                                            <tr> 
                                                <th>#</th> 
                                                <th>Solicitado</th>
                                                <th>#Pedido</th>
                                                <th>Estado</th>
                                                <th>Total</th>                                     
                                                <th class="text-center">Acciones</th> 
                                            </tr> 
                                        </thead>
                                        <tbody> 
                                            
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <div role="tabpanel" class="tab-pane" id="lugares">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead> 
                                            <tr> 
                                                <th>#</th> 
                                                <th>Direccion</th>
                                                <th>Mapa</th>
                                                <th>Estado</th>                                
                                                <th class="text-center">Acciones</th> 
                                            </tr> 
                                        </thead>
                                        <tbody> 
                                            @foreach($lugares as $item)
                                                <tr>                                 
                                                    <th>{{$item->id}}</th>
                                                    <th>{{$item->direccion}}</th>
                                                    <th>
                                                        <button class="btn btn-info btn-xs"> <span class="glyphicon glyphicon-map-marker"></span> Mapa</button>
                                                    </th>
                                                    <th>
                                                        @if($item->habilitado)
                                                            <input type="checkbox" checked data-size="mini" data-toggle="toggle" data-on="SI" disabled> 
                                                        @else
                                                            <input type="checkbox" data-size="mini" data-toggle="toggle" data-off="NO" disabled>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        <button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
                                                    </th>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $(document).ready(function() 
    {
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
    });
</script>
@endsection
