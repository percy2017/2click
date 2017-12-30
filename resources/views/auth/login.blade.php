@extends('frontend.layouts.app')

@section('mystyle')
<link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="text-center">
                            Login {{config('app.name')}}
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form  method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo electronico" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Contraseña"  required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="remember" data-toggle="toggle" data-on="SI" data-off="NO" {{ old('remember') ? 'checked' : '' }}> Recuerdame
                                        
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-heart-empty"></span> Entrar
                                    </button>
                                </div> 
                            </div>
                            <hr>
                             <div class="form-group">
                                <a href="{{ route('social.auth', 'facebook') }}" class="btn btn-block btn-social btn-facebook">
                                    <span class="fa fa-facebook"></span> Entrar con facebook
                                </a>
                            </div>
                            <div class="form-group">
                                <a href="{{ route('social.auth', 'google') }}" class="btn btn-block btn-social btn-google">
                                    <span class="fa fa-google"></span> Entrar con google
                                </a>
                            </div>
                            <div class="form-group">
                                <a href="{{ route('social.auth', 'twitter') }}" class="btn btn-block btn-social btn-twitter">
                                    <span class="fa fa-twitter"></span> Entrar con Twitter
                                </a>
                            </div>

                        </form>
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
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $(document).ready(function() 
    {
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
    });
</script>
@endsection
