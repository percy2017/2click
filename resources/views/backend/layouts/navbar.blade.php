<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/admin') }}">
                <span class="glyphicon glyphicon-globe"></span> {{ config('app.name') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cutlery"></span> Negocios <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('proveedores.create') }}">Nuevo Negocio</a></li>
                        <li><a href="{{ route('proveedores.index') }}">Mis Negocios</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('productos.create') }}">Nuevo Producto</a></li>
                        <li><a href="{{ route('productos.index') }}">Mis Producto</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Ingresos</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-dashboard"></span> Logistica <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Pedidos</a></li>
                        <li><a href="#">Monedero</a></li>
                        
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span> Pedidos <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">En Cola</a></li>
                        <li><a href="#">Mensajeros</a></li>
                        <li><a href="{{ route('pedidos.proveedores') }}">Proveedores</a></li>

                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-lock"></span> Administracion <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('usuarios.index')}}">Usuarios</a></li>
                        <li><a href="{{route('notificaciones.index')}}">Notificaciones</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{route('localidades.index')}}">Localidades</a></li>
                        <li><a href="{{route('referencias.index')}}">Referencias</a></li>
                        
                        <li role="separator" class="divider"></li>
                        <li><a href="{{route('pagos.index')}}">Pagos</a></li>
                        <li><a href="{{route('estados.index')}}">Estados</a></li>
                        <li><a href="{{route('cupones.index')}}">Cupones</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{route('categorias.index')}}">Categorias</a></li>
                        <li><a href="{{route('tipos.index')}}">Tipos</a></li>
                        
                        
                        
                        <!-- <li role="separator" class="divider"></li> -->
                    </ul>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <li class="dropdown" role="presentation">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-bell"></span> Notificaciones <span class="badge">{{count($notificaciones)}}</span><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($notificaciones as $item)
                            <li>
                                <a href="{{$item->ruta}}">
                                    {{$item->mensaje}}
                                    <div class="pull-right"><small>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</small></div>
                                </a>
                                
                            </li>
                        @endforeach
                    </ul>
                </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            <span class="glyphicon glyphicon-user"></span> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="{{ route('login') }}">Perfil</a></li>
                            <li><a href="{{ url('/') }}"  target="_blank">Principal</a></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Salir
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
               
            </ul>
        </div>
    </div>
</nav>