<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('imagenes/2click/logo.png') }}" type="image/x-icon">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/confirm/jquery-confirm.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/file-input/fileinput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toggle/css/bootstrap-toggle.min.css') }}">
    @yield('mystyle')
    <style>
      body { padding-top: 70px; }
    </style>
</head>
<body>
    <div id="app">
        @include('frontend.layouts.navbar')

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('plugins/jquery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/confirm/jquery-confirm.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/file-input/fileinput.min.js') }}"></script>
    <script src="{{ asset('plugins/toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script>
    $(document).ready(function() 
    {
        cant_carrito();
    });
    function noti(urli)
    {
      // alert(urli);
      $.ajax({
        url: urli,
        type: 'GET',
      })
      .done(function() {

        // console.log("success");
      })
      .fail(function() {
        // console.log("error");
      })
      .always(function() {
        // console.log("complete");
      });
      
    }
    function cant_carrito()
    {
      $.ajax({
              method: 'get',
              url: '{{route('carrito.cantidad')}}',
              success: function(result)
              {
                  // document.getElementById('label-carrito-cant').innerHTML = 'Carrito('+result+')';
                  // document.getElementById('label-carrito-cant2').innerHTML = 'Carrito('+result+')';
                  document.getElementById('label-carrito-cant').innerHTML = '<span class="badge">'+result+'</span><i class="fa fa-shopping-cart"></i>';
                  document.getElementById('label-carrito-cant2').innerHTML = result;
                  // console.log('cantidad de productos en el carrito: '+result);


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
    </script>
    @yield('myscript')
</body>
</html>