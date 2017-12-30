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
                        
                        <h3>
                            Proveedores del Sistemas
                            <div class="pull-right">
                                <a href="{{ URL::previous() }}" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i> Atras</a>
                            </div>
                        </h3>
                        
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead> 
                                    <tr> 
                                        <th>#</th> 
                                        <th>Logo</th>
                                        <th>Representante</th>
                                        <th>Tipo</th>
                                        <th>Comision</th>
                                        <th>Nombre</th>
                                        <th>Direccion</th>
                                        <th>Whatsapp</th>  
                                        <th>Habilitado</th>
                                        <th>Creado</th>
                                        <th>Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($proveedores as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <td>
                                            <a href="#" onclick="mostrar_imagen('{{$item->logo}}')">
                                                <img src="{{ asset('imagenes/proveedores/'.$item->logo) }}" class="img-responsive img-circle" style="width: 30px; height: 30px;">
                                            </a>
                                        </td>
                                        <td><u>{{$item->representante}}</u></td>
                                        <td><u>{{$item->tipo}}</u></td>
                                        <td>
                                            {{ $item->precio }}
                                            <button onclick="comision_editar('{{ route('comision.editar', array($item->id, ':comision')) }}')" class="btn btn-xs btn-warning"><span class="fa fa-refresh"></span></button>
                                        </td>
                                        <td>{{$item->nombre_comercial}}</td> 
                                        <td>{{$item->direccion}}</td> 
                                        <td>{{$item->whatsapp}}</td> 
                                        <td>
                                            @if($item->habilitado)
                                                <input type="checkbox" checked data-size="mini" data-toggle="toggle" data-on="SI" disabled> 
                                            @else
                                                <input type="checkbox" data-size="mini" data-toggle="toggle" data-on="SI" disabled>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                        
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Ver</a>
                                        </td> 
                                    </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                    <div class="panel-footer text-center">
                        {{$proveedores->links()}}
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
    function comision_editar(urli)
    {
        $.alert({
        title: 'Actualizar Comision',
        content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>Comision ?</label>' +
                '<input id="comision" type="number" class="form-control" value="4" required />' +
                '</div>' +
                '</form>',
        icon: 'fa fa-opencart',
        animation: 'scale',
        closeAnimation: 'scale',
        closeIcon: true,
        draggable: true,
        buttons: {
            'confirm': {
                    text: '<i class="fa fa-check"></i> OK',
                    btnClass: 'btn-primary',
                    action: function () 
                    {
                        var comision = document.getElementById('comision').value;
                        urli = urli.replace(':comision', comision);
                        
                         $.ajax({
                            method: 'get',
                            url: urli,
                            success: function(result)
                            {
                                
                                location.reload();
                            },
                            error: function(){
                               
                                $.alert({
                                      title: 'Error.!',
                                      content: 'Ups. Algo salio mal en tu carrito.',
                                      icon: 'fa fa-info',
                                      animation: 'scale',
                                      type: 'red',
                                      closeAnimation: 'scale',
                                      buttons: {
                                          okay: {
                                              text: 'OK',
                                              btnClass: 'btnClass-blue'
                                          }
                                      }
                                  });
                            },

                        });
                    }
                }
        }
    });
}
</script>
@endsection
