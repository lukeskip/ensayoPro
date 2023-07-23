@extends('layouts.reyapp.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="large-6 medium-8 medium-centered columns login">
            <div class="panel panel-default">
                <div class="text-center"><img src="{{asset('img/logo_ensayo.png')}}" alt="" width="180px;"></div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo:</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña:</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recuerdame
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="button green expanded">
                                    Entrar
                                </button>
                                <!-- <a href="{{url('/redirect')}}" class="button facebook expanded">
                                    <i class="fa fa-facebook"></i>
                                    Login con Facebook
                                </a> -->

                            </div>
                        </div>
                        <div class="alternatives">
                            <a class="" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                                <a href="/registro/">¿No tienes una cuenta? ¡Regístrate!</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
