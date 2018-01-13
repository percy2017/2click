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
            <div class="col-xs-12 col-md-9 col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
   
                            <div class="input-group">
                              <input type="text" id="criterio" class="form-control" placeholder="Busca tu producto..">
                              <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="productos_buscar('{{ route('productos_buscar',':criterio') }}')"><i class="fa fa-search"></i></button>
                                
                                <a href="{{ route('carrito.ver') }}" class="btn btn-default" type="button"><i class="fa fa-shopping-cart"></i><span class="badge"><div id="label-carrito-cant2"></div></span></a>
                                <button class="btn btn-primary" type="button" onclick="productos_index()"><i class="fa fa-home"></i></button>
                              </span>
                            </div>
                    </div>

                    <div class="panel-body">
                        <div id="cargando1" class="text-center">
                            <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
                            <p>{{ config('app.mensaje_cargando') }}</p>
                        </div>
                        <div id="cargado1" style="display:none;">
                            <div id="productos_index"></div>  
                        </div>                        
                    </div>
                    <div class="panel-footer text-center">
                        {{ config('app.myfooter') }}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3 col-sm-3">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <label>
                            Catalogo
                        </label>
                    </div>
                    <div class="panel-body"> 
                        <ul class="text-left">
                            @foreach($catalogos as $item)
                            <li>
                                <a href="#" onclick="productos_catalogo('{{ route('productos_catalogo',$item->id) }}')">{{ $item->nombre }}</a>    
                            </li>                                                    
                        @endforeach 
                        </ul>
                                                      
                    </div>
                   <!--  <div class="panel-footer text-center">
                        <a href="#">Ver todos</a>
                    </div> -->
                </div>
                
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <label>
                            Proveedores
                        </label>
                    </div>
                    <div class="panel-body">
                        <ul class="text-left">
                            @foreach($proveedores as $item)
                            <li>
                                <a href="#" onclick="productos_proveedor('{{ route('productos_proveedor',$item->id) }}')">{{ $item->nombre_comercial }}</a>
                            </li>                            
                        @endforeach
                        </ul>
                                                       
                    </div>
                    <!-- <div class="panel-footer text-center">
                        <a href="#">Ver todos</a>
                    </div> -->
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <label>
                            Tienes Preguntas ?
                        </label>
                    </div>

                    <div class="panel-body">
                        <div class="mcwidget-embed" data-widget-id="912022"></div>
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
        productos_index();
    });

    function productos_proveedor(urli)
    {
        // alert(urli);
        document.getElementById('cargando1').style.display = 'block';
        document.getElementById('cargado1').style.display = 'none';
        $.ajax({
            url: urli,
            type: 'GET',
        })
        .done(function(result) {

            $('#productos_index').empty().html(result);
            document.getElementById('cargando1').style.display = 'none';
            document.getElementById('cargado1').style.display = 'block';
            // console.log(result);
        })
        .fail(function() {
            // console.log("error");
        })
        .always(function() {
            // console.log("complete");
        });
    }

    function productos_catalogo(urli)
    {
        // alert(urli);
        document.getElementById('cargando1').style.display = 'block';
        document.getElementById('cargado1').style.display = 'none';
        $.ajax({
            url: urli,
            type: 'GET',
        })
        .done(function(result) {

            $('#productos_index').empty().html(result);
            document.getElementById('cargando1').style.display = 'none';
            document.getElementById('cargado1').style.display = 'block';
            // console.log(result);
        })
        .fail(function() {
            // console.log("error");
        })
        .always(function() {
            // console.log("complete");
        });
    }
    function productos_index()
    {
        document.getElementById('criterio').value = "";
        document.getElementById('cargando1').style.display = 'block';
        document.getElementById('cargado1').style.display = 'none';
        $.ajax({
            url: '{{ route('productos_index') }}',
            type: 'GET',
        })
        .done(function(result) {

            $('#productos_index').empty().html(result);
            document.getElementById('cargando1').style.display = 'none';
            document.getElementById('cargado1').style.display = 'block';
            // console.log(result);
        })
        .fail(function() {
            // console.log("error");
        })
        .always(function() {
            // console.log("complete");
        });
    }
    function productos_buscar(urli)
    {
        
        var criterio = document.getElementById('criterio').value;
        if(criterio)
        {
            document.getElementById('cargando1').style.display = 'block';
            document.getElementById('cargado1').style.display = 'none';
            urli = urli.replace(':criterio', criterio);
            // alert(urli);
            $.ajax({
                url: urli,
                type: 'GET',
            })
            .done(function(result) {
                $('#productos_index').empty().html(result);
                document.getElementById('cargando1').style.display = 'none';
                document.getElementById('cargado1').style.display = 'block';
                // console.log(result);
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                // console.log("complete");
            });
        }else
        {
            $.alert({
                title: 'Error',
                content: 'Debe ingresar un criterio de busqueda.',
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
        }
        
        
    }

    $(document).on('click', '.pagination li a', function(event) {
        event.preventDefault();
        /* Act on the event */
        document.getElementById('cargando1').style.display = 'block';
        document.getElementById('cargado1').style.display = 'none';
        var url = $(this).attr("href");
        $.ajax({
            url: url,
            type: 'GET'
        })
        .done(function(result) {
            $('#productos_index').empty().html(result);
            document.getElementById('cargando1').style.display = 'none';
            document.getElementById('cargado1').style.display = 'block';
            // console.log("success");
        })
        .fail(function() {
            // console.log("error");
        })
        .always(function() {
            // console.log("complete");
        });
        
    });

    function add_carrito(urli, cantDisponible) 
    {
        $.confirm({
            escapeKey: 'cancel',
            title: 'Agregar',
            content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Cantidad ?</label>' +
                    '<input id="cant" type="number" step="1" min="1"  max="'+cantDisponible+'" class="name form-control" value="1" required pattern="{0,10}"/>' +
                    '<label>Cantidad disponible: '+cantDisponible+'</label>' +
                    '</div>' +
                    '</form>',
            buttons: {
                formSubmit: {
                    text: 'Ok',
                    btnClass: 'btn-blue',
                    action: function () 
                    {
                        var cant = document.getElementById('cant').value;
                        // alert(cant+' - '+cantDisponible);
                        if(parseInt(cant) > parseInt(cantDisponible))
                        {
                            $.alert({
                                title: 'Cantidad Superada',
                                content: 'Su pedido supero la cantidad disponible.',
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
                        }else
                        {
                            urli = urli.replace(':cant', cant);
                            $.ajax({
                                method: 'get',
                                url: urli,
                                success: function(result)
                                {
                                    // console.log('cantidad de productos en el carrito: '+result);
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
</script>
@endsection

