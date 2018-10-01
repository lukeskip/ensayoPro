@extends('layouts.reyapp.landing')

@section('content')
<div class="container">
    <div class="row">
        <div class="large-6 medium-8 medium-centered columns login">
            <div class="panel panel-default">
                <div class="text-center"><img src="{{asset('img/logo_rey.png')}}" alt="" width="180px;"></div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <br>
                                <a href="{{url('/redirect')}}" class="button facebook expanded">
                                    <i class="fa fa-facebook"></i>
                                    Login con Facebook
                                </a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
