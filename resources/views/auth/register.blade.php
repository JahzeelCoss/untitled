@extends('layout.base')
@section('container')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @include('layout.formerror')
            {!! Form::open(array('method'=>'POST', 'url'=>'auth/register', 'class'=>'form-horizontal')) !!}
            <h2 class="form-signin-heading">Registro</h2>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Nombre Completo</label>
                <div class="col-sm-10">
                    {!! Form::text('name', old('name'), array('class'=>'form-control', 'placeholder'=>'Nombre', 'required'=>'true')) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">E-mail</label>
                <div class="col-sm-10">
                    {!! Form::email('email',old('email') ,array('class'=>'form-control', 'placeholder'=>'E-mail', 'required'=>'true')) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label">Usuario</label>
                <div class="col-sm-10">
                    {!! Form::text('username', old('username'), array('class'=>'form-control', 'placeholder'=>'Usuario', 'required'=>'true')) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Contraseña</label>
                <div class="col-sm-10">
                    {!! Form::password('password', array('class'=>'form-control', 'placeholder'=>'Contraseña', 'required'=>'true')) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="col-sm-2 control-label">Confirmar Contraseña</label>
                <div class="col-sm-10">
                    {!! Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Contraseña', 'required'=>'true')) !!}
                </div>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Registrarse</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection