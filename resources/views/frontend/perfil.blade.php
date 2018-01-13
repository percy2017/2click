@extends('frontend.layouts.app')
@section('mystyle')
@endsection
@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
    <p>{{ config('app.mensaje_cargando') }}</p>
</div>
<div id="cargado" style="display:none;">
    @include('frontend.mapas.create')
    <div class="container">
         @if(\Session::has('mensaje_info'))
            <div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Info!</strong> {{ \Session::get('mensaje_info') }}
            </div>
        @endif
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            <span class="fa fa-user"></span>
                            Mi Perfil
                            <div class="pull-right">
                                <a href="{{ URL::previous() }}" class="btn btn-danger"><i class="fa fa-reply"></i>Atras</a>
                                <a href="{{ route('perfil.editar') }}" class="btn btn-primary"><span class="fa fa-edit"></span> Editar</a>
                            </div>
                        </h4>
                    </div>

                    <div class="panel-body">                        
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <div class="text-center">
                            <img class="img-responsive img-thumbnail" src="{{ asset('imagenes/users/'.auth::user()->foto) }}" alt="" />
                          </div>
                          
                          <br>
                          <div class="">
                            <label> 
                                <u>{{ App\Rol::where('id',Auth::user()->rol_id)->first()->nombre }}</u>                                 
                                <span class="fa fa-puzzle-piece"></span> 
                            </label> 
                          <br>                             
                          <label>{{ Auth::user()->name }} <span class="fa fa-user"></span> </label>
                          <br>
                          <label>{{ Auth::user()->email }} <span class="fa fa-exclamation-sign"></span> </label>
                          <br>
                          <label>{{ Auth::user()->whatsapp }} <span class="fa fa-phone"></span> </label>
                          <br>
                          <label>{{ Auth::user()->carnet }} <span class="fa fa-credit-card"></span> </label>
                          <br>
                          <label>
                            {{ App\Localidad::where('id',Auth::user()->localidad_id)->first()->nombre }} <span class="fa fa-map-marker"></span> 
                          </label>
                          </div>
                          
                                
                        </div>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#pedidos" aria-controls="home" role="tab" data-toggle="tab">Historico de pedidos</a></li>
                            <li role="presentation"><a href="#lugares" aria-controls="profile" role="tab" data-toggle="tab">Lugares de entrega</a></li>
                          </ul>

                          <!-- Tab panes -->
                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="pedidos">
                                <div class="table-responsive">
                                    @if(count($pedidos)>0)
                                        <table class="table table-hover table-bordered">
                                        <thead> 
                                            <tr> 
                                                <th>#</th> 
                                                <th>Solicitado</th>
                                                <th>#Pedido</th>
                                                <th>Direccion</th>
                                                <th>Estado</th>
                                                <th>Total</th>                                     
                                                <!-- <th class="text-center">Acciones</th>  -->

                                            </tr> 
                                        </thead>
                                        <tbody> 

                                            @foreach($pedidos as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->direccion }}</td>
                                                <td><u>{{ $item->nombre }}</u></td>
                                                <td>{{ number_format($item->total,2) }}</td>
                                            </tr>
                                                
                                            @endforeach()
                                        </tbody>
                                    </table>
                                    @else
                                        <div class="form-group text-center">
                                            <h3>
                                                Sin historial en pedidos
                                            </h3>
                                            <a href="{{ route('index')}}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Nuevo Pedido</a>
                                        </div>
                                    @endif
                                    
                                </div>
                                
                            </div>
                            <div role="tabpanel" class="tab-pane" id="lugares">
                                @if(count($lugares)>0)
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
                                                        <button class="btn btn-info btn-xs"> <span class="fa fa-map-marker"></span> Mapa</button>
                                                    </th>
                                                    <th>
                                                        @if($item->habilitado)
                                                            <input type="checkbox" checked data-size="mini" data-toggle="toggle" data-on="SI" disabled> 
                                                        @else
                                                            <input type="checkbox" data-size="mini" data-toggle="toggle" data-off="NO" disabled>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        <button class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Eliminar</button>
                                                    </th>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                    <div class="form-group text-center">
                                        <h3>
                                            No tienes ubicaciones
                                        </h3>
                                        <a href="{{ route('index')}}" class="btn btn-primary" data-toggle="modal" data-target="#modal_mapa_create" type="button" onclick="cargar_mapa()"><i class="fa fa-map-marker"></i> Nueva ubicacion</a>
                                    </div>
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
        </div>
    </div>
</div>
@endsection
@section('myscript')
<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.googleapis')}}"></script>
<script src="{{ asset('js/mapa.js') }}"></script>
<script>
    $(document).ready(function() 
    {
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
    });
    function cargar_mapa()
    {
      initMap();
    }
</script>
@endsection
