@extends('layout.base')
@section('container')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @include('layout.formerror')
            {!! Form::open(array('method'=>'POST', 'url'=>'auth/login')) !!}
            <h2 class="form-signin-heading">Iniciar sesión</h2>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                {!! Form::text('username', old('username'), array('class'=>'form-control', 'placeholder'=>'Usuario', 'required'=>'true')) !!}
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                {!! Form::password('password', array('class'=>'form-control', 'placeholder'=>'Contraseña', 'required'=>'true')) !!}
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="remember"> Recordarme
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection