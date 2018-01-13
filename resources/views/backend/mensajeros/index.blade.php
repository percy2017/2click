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
                            <i class="fa fa-flash"> </i>
                            Mensajeros del Sistema
                            <div class="pull-right">
                                <a href="{{ route('mensajeros.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nuevo</a>
                                <a href="{{ URL::previous() }}" class="btn btn-danger btn-sm">
                                   <i class="fa fa-reply"></i> Atras
                                </a>
                            </div>
                        </h3>              
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead> 
                                    <tr> 
                                        <th>#</th> 
                                        <th>Alias</th> 
                                        <th>Nombre Completo</th> 
                                        <th>Whatsapp</th>
                                        <th>Vehiculo</th>
                                        <th>Habilitado</th>
                                        <th>Creado</th> 
                                        <th>Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($mensajeros as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <td>{{$item->alias}}</td> 
                                        <td>{{$item->name}}</td> 
                                        <td>{{$item->whatsapp}}</td> 
                                        <td>{{ $item->vehiculo }}</td>
                                        <td>
                                            @if($item->habilitado == 1)
                                                <input type="checkbox" disabled data-toggle="toggle" data-on="SI" data-size="mini" checked>              
                                            @else
                                                <input type="checkbox" disabled data-toggle="toggle" data-off="NO" data-size="mini">
                                            @endif
                                        </td> 
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                        
                                        <td class="text-center">
                                           <button onclick="asignar('{{ route('pedidos.asignar', array($item->id, ':pedido_id')) }}','{{ route('pedidos.encola') }}')" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modalNotificacionEdit"><i class="fa fa-magic"></i> Asignar</button>
                                           <button onclick="#" class="btn btn-xs btn-warning"><i class="fa fa-trash"></i> Elminar</button>
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
        $('.myselector').select2();
    });
    function asignar(urli, vista)
    {
        // alert(urli);
        $.confirm({
            escapeKey: 'cancel',
            title: 'Asignar pedido',
            content: '' +
                    '<form action="" class="formName">' +
                        '<div class="form-group">' +
                            '<label># del Pedido</label>' +
                            '<input id="pedido_id" type="number" class="form-control" required />' +
                        '</div>' +
                    '</form>',
            buttons: {
                formSubmit: {
                    text: 'OK',
                    btnClass: 'btn-blue',
                    action: function () 
                    {
                        var pedido_id = document.getElementById('pedido_id').value;
                        urli = urli.replace(':pedido_id', pedido_id);     
                        // alert(urli);               
                        $.ajax({
                            method: 'get',
                            url: urli,
                            success: function(result)
                            {
                                // console.log('cantidad de productos en el carrito: '+result);
                                location.href= vista;
                            },
                            error: function(){
                               
                                $.alert({
                                      title: 'Error.!',
                                      content: 'Ups. Algo.',
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
