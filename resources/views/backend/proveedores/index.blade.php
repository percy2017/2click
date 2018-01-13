@extends('backend.layouts.app')
@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
    <p>{{ config('app.mensaje_cargando') }}</p>
</div>
<div id="cargado" style="display:none;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        
                        <h4>
                            <span class="fa fa-cutlery"></span>
                              Mis Negocios
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
                                        <th>Logo</th>
                                        <th>Tipo</th>
                                        <th>Nombre Comercial</th>
                                        <th>Direccion</th>
                                        <th>Whatsapp</th>  
                                        <th>Abierto</th>                                     
                                        <th>Actualizado</th>
                                        <th class="text-center">Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($proveedores as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        
                                        <td>
                                            <a href="#" onclick="mostrar_imagen('{{asset('imagenes/proveedores/'.$item->logo)}}')">
                                                <img src="{{asset('imagenes/proveedores/'.$item->logo)}}" alt="{{$item->nombre_comercial}}" class="img-responsive img-circle" style="width: 30px; height: 30px;">
                                            </a>
                                            
                                        </td>
                                        <td> <u>{{ $item->nombre }}</u></td>
                                        <td>{{ $item->nombre_comercial }}</td>
                                        <td>{{ $item->direccion }}</td> 
                                        <td>{{ $item->whatsapp }}</td> 
                                        <td>
                                            @if($item->habilitado)
                                                <input type="checkbox" checked data-size="mini" data-toggle="toggle" data-on="SI" disabled> 
                                            @else
                                                <input type="checkbox" data-size="mini" data-toggle="toggle" data-off="NO" disabled>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                        
                                        <td class="text-center">
                                            <a href="{{ route('proveedores.edit',$item->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>Editar</a>
                                            @if($item->habilitado)
                                                <button class="btn btn-danger btn-xs" onclick="cerrar('{{ route('proveedores.cerrar',$item->id) }}')">
                                                <i class="fa fa-thumbs-o-down"></i> Cerrar
                                            </button>
                                            @else
                                                <button class="btn btn-primary btn-xs" onclick="abrir('{{ route('proveedores.abrir',$item->id) }}')">
                                                <i class="fa fa-thumbs-o-up"></i> Abrir
                                            </button>
                                            @endif
                                            
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
    function mostrar_imagen(imagen)
    {
        $.alert({
            title:'',
            content: '<img class="img-responsive" width=100% src="'+imagen+'">',
            escapeKey: 'close',
            theme: 'supervan',
            buttons: {
                close: function()
                {

                }
            }
        });
    }
    function cerrar(urli)
    {
        // alert(urli);
        $.confirm({
            escapeKey: 'cancel',
            title: 'Cerrar',
            content: 'Estas seguro de cerrar tu negocio? <br> Con esta accion todo tus producto ya NO estaran disponible al publico.',
            buttons: {
                formSubmit: {
                    text: 'SI',
                    btnClass: 'btn-blue',
                    action: function () 
                    {     
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
                                      content: 'Ups. Algo salio mal.',
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
                },
                cancel: function () 
                {
                    //close
                },
            },
            onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
        });
    }
    function abrir(urli)
    {
        // alert(urli);
        $.confirm({
            escapeKey: 'cancel',
            title: 'Abrir',
            content: 'Estas listo para ofrecer tus productos al publico?',
            buttons: {
                formSubmit: {
                    text: 'SI',
                    btnClass: 'btn-blue',
                    action: function () 
                    {     
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
                                      content: 'Ups. Algo salio mal.',
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
                },
                cancel: function () 
                {
                    //close
                },
            },
            onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
        });
    }
</script>
@endsection
