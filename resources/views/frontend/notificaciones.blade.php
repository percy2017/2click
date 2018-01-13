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
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                          <i class="fa fa-bell"></i>
                            Mis Notificaciones
                            <div class="pull-right">

                                <a href="{{ URL::previous() }}" class="btn btn-danger"><i class="fa fa-reply"></i> Atras</a>
                            </div>
                        </h4>
                    </div>

                    <div class="panel-body">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover table-bordered">
                                <tr>
                                  <th>#</th>
                                  <th>Creado</th>
                                  <th>Mensaje</th>
                                  <th>Ruta</th>
                                  <!-- <th>Visto</th> -->
                                </tr>
                                @foreach($notificaciones_all as $item)
                                <tr>
                                  <!-- <td>{{$loop->iteration}}</td> -->
                                  <td>{{ $item->id }}</td>
                                  <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                  <td>{{ $item->mensaje }}</td>
                                  <td><a href="{{ $item->ruta }}">{{ $item->ruta }}</a></td>
                                @endforeach
                            </table>                 
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
<script>
    $(document).ready(function() 
    {
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
    });
</script>
@endsection

