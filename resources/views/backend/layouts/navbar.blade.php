<nav class="navbar navbar-default navbar-fixed-top">
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
             <a class="navbar-brand" href="#">
                    <img alt="2Click" class="img-responsive img-circle" style="width: 30px; height: 30px;" src="{{ asset('imagenes/2click/logo.jpg') }}">
                </a>
            <a class="navbar-brand" href="{{ url('/admin') }}">
               
                 {{ config('app.name') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-delicious"></i> Negocios <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('proveedores.create') }}">Nuevo Negocio</a></li>
                        <li><a href="{{ route('proveedores.index') }}">Mis Negocios</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('productos.create') }}">Nuevo Producto</a></li>
                        <li><a href="{{ route('productos.index') }}">Mis Producto</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('solicitudes.index') }}">Sol. en Cola</a></li>
                        <li><a href="{{ route('ingresos.index') }}">Ingresos</a></li>
                    </ul>
                </li>
   <!--              <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-trucki"></i> Logistica <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Pedidos</a></li>
                        <li><a href="#">Monedero</a></li>
                        
                    </ul>
                </li> -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-shopping-cart"></i> Pedidos <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('pedidos.encola') }}">En Cola</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('pedidos.proveedores') }}">Proveedores</a></li>
                        <li><a href="{{ route('mensajeros.index') }}">Mensajeros</a></li>
                        <li><a href="{{ route('pedidos.items') }}">Items</a></li>

                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-briefcase"></i> Administracion <span class="caret"></span></a>
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
                        <li><a href="{{route('vehiculos.index')}}">Vehiculos</a></li>
                        
                        
                        
                        <!-- <li role="separator" class="divider"></li> -->
                    </ul>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <li class="dropdown" role="presentation">
                    <a onclick="noti('{{ route('notificacion.ver') }}')" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="badge">{{count($notificaciones)}}</span><i class="fa fa-bell"></i><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($notificaciones as $item)
                            <li>
                                <a href="{{$item->ruta}}">
                                    {{$item->mensaje}}-{{$item->ruta}}
                                    <div class="pull-right">
                                        <small>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</small>
                                    </div>
                                </a>
                                
                            </li>
                        @endforeach
                        <li>
                            <a href="{{ route('notificacion.index') }}" class="text-center">
                                Ver todos
                                <div class="pull-right">
                                    <small></small>
                                </div>
                            </a>
                            
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="{{ route('perfil') }}">Perfil</a></li>
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