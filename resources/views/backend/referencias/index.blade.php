@extends('backend.layouts.app')
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
                            <span class="glyphicon glyphicon-cutlery"></span>
                              Referencias de Lugares
                            <div class="pull-right">
                                <a href="{{route('proveedores.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nuevo</a>
                                <a href="{{ URL::previous() }}" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i> Atras</a>
                            </div>
                        </h4>
                        
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead> 
                                    <tr> 
                                        <th>#</th> 
                                        <th>Nombre</th>                                   
                                        <th>Creado</th>
                                        <th class="text-center">Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($referencias as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <th>{{$item->nombre}}</th> 
                                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                        
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Ver</a>
                                            <a href="#" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>Editar</a>
                                            <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Eliminar</a>
                                        </td> 
                                    </tr> 
                                    @endforeach
                                </tbody>
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
