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
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <!-- <ul class="nav navbar-nav">
                &nbsp;
            </ul> -->

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <li><a href="{{ route('carrito.ver') }}"><div id="label-carrito-cant"></div></a></li>
                @guest

                    <li><a href="{{ route('login') }}"><span class="glyphicon glyphicon-user"></span> Login</a></li>
                    <li><a href="{{ route('registro') }}"><span class="glyphicon glyphicon-pencil"></span> Registro</a></li>
                @else
                    
                    <li class="dropdown" role="presentation">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="badge">{{count($notificaciones)}} </span> Notificaciones<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach($notificaciones as $item)
                                <li>
                                    <a href="{{ url($item->ruta) }}">
                                        {{$item->mensaje}}
                                        <div class="pull-right"><small>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</small></div>
                                    </a>
                                    
                                </li>
                            @endforeach
                            
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            <span class="glyphicon glyphicon-user"></span>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('perfil') }}">
                                    Perfil
                                </a>

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
                @endguest
            </ul>
        </div>
    </div>
</nav>