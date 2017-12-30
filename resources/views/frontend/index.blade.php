@extends('frontend.layouts.app')
@section('mystyle')

@endsection
@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-9 col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            Productos
                            <div class="pull-right">
                                <a href="{{ route('carrito.ver') }}" class="btn btn-default"><div id="label-carrito-cant2"></div></a>
                                <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>Buscar</button>
                                
                            </div>
                        </h4>
                    </div>

                    <div class="panel-body">
                       
                        @foreach($productos as $item)
                            <!-- <div class="row"> -->
                            <div class="col-sm-6 col-md-4 col-xs-12">
                                <div class="thumbnail">
                                    
                                    <img src="{{ asset('imagenes/productos/'.$item->imagen) }}" alt="{{$item->nombre}}" style="height: 150px; width: 100%;">
                                    <div class="caption">
                                        <div>
                                            <img src="{{ asset('imagenes/proveedores/'.$item->logo) }}" alt="{{$item->nombre_comercial}}" class="img-circle" style="height: 20px; width: 20px;">
                                            {{$item->nombre_comercial}}
                                        </div>

                                        <h4><strong>{{$item->nombre}}</strong> </h4>
                                        <p>{{$item->descripcion}}</p> 
                                        <hr>
                                        <div>
                                            <h3>
                                                <strong>{{$item->precio}} Bs.</strong>
                                                <div class="pull-right">
                                                    <button onclick="add_carrito('{{route('carrito.agregar', array($item->id, ':cant')) }}','{{$item->cantidad}}')" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Pedir</button>
                                                </div>
                                            </h3>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->
                        @endforeach
                     
                    </div>
                    <div class="panel-footer text-center">
                        {{ config('app.myfooter') }}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3 col-sm-3">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h4>
                            Catalogo
                        </h4>
                    </div>

                    <!-- <div class="panel-body">
                       
                        
                    </div> -->
                    <div class="list-group">
                            @foreach($catalogos as $item)
                                <a href="{{ route('catalogo') }}" class="list-group-item">{{ $item->nombre }}</a>
                            @endforeach

                        </div>
                    <div class="panel-footer text-center">
                        <a href="#">Ver todos</a>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h4>
                            Tienes Preguntas ?
                        </h4>
                    </div>

                    <div class="panel-body">
                        <!-- <div class="mcwidget-embed" data-widget-id="912022"></div> -->
                        <div class="text-center"><a target=”_blank” href="https://api.whatsapp.com/send?phone=59171130523&text=Tengo una consulta" class="btn btn-success btn-md"> <i class="fa fa-whatsapp"></i> Chat en whatsapp</a></div>
                        
                    </div>
                    <div class="panel-footer text-center">
                        Linea directa con pedidos 2click.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('myscript')
<script src="//widget.manychat.com/370885596671038.js" async="async"></script>
<script>
    $(document).ready(function() 
    {
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
        
        cant_carrito();
    });
function cant_carrito()
{

    $.ajax({
          method: 'get',
          url: '{{route('carrito.cantidad')}}',
          success: function(result)
          {
              // document.getElementById('label-carrito-cant').innerHTML = 'Carrito('+result+')';
              // document.getElementById('label-carrito-cant2').innerHTML = 'Carrito('+result+')';
              document.getElementById('label-carrito-cant').innerHTML = '<span class="glyphicon glyphicon-shopping-cart"></span>Carrito('+result+')';
                document.getElementById('label-carrito-cant2').innerHTML = '<span class="glyphicon glyphicon-shopping-cart"></span>Carrito('+result+')';
              console.log('cantidad de productos en el carrito: '+result);


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
function add_carrito(urli, cantDisponible) 
{
 $.alert({
        title: 'Agregar',
        content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>Cantidad ?</label>' +
                '<input id="cant" type="number" step="1" min="1"  max="'+cantDisponible+'" class="name form-control" value="1" required />' +
                '<p>Cantidad disponible: '+cantDisponible+'</p>' +
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
                        var cant = document.getElementById('cant').value;
                        urli = urli.replace(':cant', cant);
                        
                         $.ajax({
                            method: 'get',
                            url: urli,
                            success: function(result)
                            {
                                
                                //document.getElementById('label-carrito-cant').innerHTML = 'Carrito('+ result + ')';
                                // document.getElementById('label-carrito-cant2').innerHTML = 'Carrito('+ result + ')';
                                console.log('cantidad de productos en el carrito: '+result);
                                cant_carrito();
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

