@extends('backend.layouts.app')

@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
@include('backend.usuarios.create')
@include('backend.usuarios.edit')
@include('backend.usuarios.pedidos_modal')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        
                        <h3>
                            <i class="fa fa-users"></i>
                            Usuarios del Sistema
                            <div class="pull-right">
                                <a href="{{route('roles.index')}}" class="btn btn-default btn-sm">Roles y Permisos</a>
                                <a href="{{route('localidades.index')}}" class="btn btn-default btn-sm">Localidades</a>
                                <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nuevo</a>
                                <a href="{{ URL::previous() }}" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i> Atras</a>
                            </div>
                        </h3>
                        
                    </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead> 
                                    <tr> 
                                        <th>#</th> 
                                        <th>Foto</th>
                                        <th>Rol</th>
                                        <th>Localidad</th>
                                        <th>Nombre</th>  
                                        <th>Origen</th>                                     
                                        <th>Correo</th> 
                                        <th>Creado</th>
                                        <th>Habilitado</th>
                                        <th class="text-center">Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($usuarios as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <td>
                                            @if($item->redsocial)
                                                <a href="#" onclick="mostrar_imagen('{{$item->foto}}')">
                                                    <img src="{{$item->foto}}" class="img-responsive img-circle" style="width: 30px; height: 30px;">
                                                </a>
                                            @else
                                                <a href="#" onclick="mostrar_imagen('{{asset('imagenes/users/'.$item->foto)}}')">
                                                    <img src="{{asset('imagenes/users/'.$item->foto)}}" alt="{{$item->name}}" class="img-responsive img-circle" style="width: 30px; height: 30px;">
                                                </a>
                                            @endif
                                        </td>
                                        <td><u>{{$item->rol}}</u></td>
                                        <td><u>{{$item->localidad}}</u></td>
                                        <td>{{$item->name}}</td> 
                                        <td>{{$item->redsocial ? $item->redsocial : config('app.name')}}</td> 
                                        <td>{{$item->email}}</td> 
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                        <td>
                                            @if($item->habilitado)
                                                <input type="checkbox" checked data-size="mini" data-toggle="toggle" data-on="SI" disabled> 
                                               <!--  <input type="checkbox" class="form-control" checked disabled> -->
                                            @else
                                                <input type="checkbox" data-size="mini" data-toggle="toggle" data-on="SI" disabled>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button onclick="pedidos('{{ route('pedidos.usuario',$item->id) }}')" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#pedidos_modal"><i class="fa fa-shopping-cart"></i> Pedidos</button>
                                            <button onclick="edit_cargar('{{ route('usuarios.edit',$item->id) }}')" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#edit_modal"><i class="fa fa-edit"></i> Editar</button>
                                            <a href="{{ route('login.admin',$item->id) }}" target="_blank" class="btn btn-xs btn-default"><i class="fa fa-user"></i>Login</a>
                                        </td> 
                                    </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                    <div class="panel-footer text-center">
                        {{$usuarios->links()}}
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
    function mostrar_imagen(imagen, descripcion)
    {
        $.alert({
            title:'',
            content: '<img class="img-responsive" width=100% src="'+imagen+'"> <p>'+descripcion+'</p>',
            escapeKey: 'close',
            theme: 'supervan',
            buttons: {
                close: function()
                {

                }
            }
        });
    }
    function edit_cargar(urli)
    {
        // alert(urli);
        $.ajax({
            url: urli,
            type: 'GET',
            dataType: 'json',
            data: {param1: 'value1'},
        })
        .done(function(result) 
        {
            document.getElementById('id').value = result.id;
            document.getElementById('rol_id').innerHTML = result.rol;
            document.getElementById('localidad_id').innerHTML = result.localidad;
            document.getElementById('name').value = result.name;
            document.getElementById('email').value = result.email;
            document.getElementById('password').value = result.password;
            document.getElementById('password_view').innerHTML = result.password;
           
            // console.log(result);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    }
    function pedidos(urli)
    {
        document.getElementById('cargando_pedidos').style.display = 'block';
        document.getElementById('tabla_pedidos').style.display = 'none';
        $.ajax({
            url: urli,
            type: 'GET',
            dataType: 'json',
            data: {param1: 'value1'},
        })
        .done(function(result) 
        {
            var cadena ='<div class="table-responsive">';
                cadena +='<table class="table table-hover table-bordered">';
                cadena +='<thead><tr>';
                cadena +='<th>#</th>';
                cadena +='<th>Pedido el</th>';
                cadena +='<th>SubTotal</th>';
                cadena +='<th>Comision</th>';
                cadena +='<th>Total</th>';
                cadena +='<th>Entregado</th>';
                cadena +='<th>Direccion</th>';
                cadena +='<th>Whatsapp</th>';
                cadena +='</tr></thead><tbody>';
            for (var i = 0; i < result.length; i++) 
            {
                cadena+='<tr><th>'+result[i].id+'</th>';
                cadena+='<th>'+result[i].created_at+'</th>';
                cadena+='<th>'+result[i].subTotal+'</th>';
                cadena+='<th>'+result[i].comision+'</th>';
                cadena+='<th>'+result[i].total+'</th>';
                cadena+='<th>'+result[i].fecha_entrega+'</th>';
                
                cadena+='<th>'+result[i].direccion+'</th>';
                cadena+='<th>'+result[i].whatsapp+'</th></tr>';
            }
            cadena +='</tbody></table></div>';
            document.getElementById('tabla_pedidos').innerHTML = cadena;
            document.getElementById('cargando_pedidos').style.display = 'none';
            document.getElementById('tabla_pedidos').style.display = 'block';

            console.log(result);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        }); 
    }
</script>
@endsection
