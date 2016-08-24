@extends('layout.base')
@section('container')
    <h1 class="page-header">Editar Rol</h1>
    {!!Notification::showAll()!!}
    @include('layout.formerror')
    {!!Form::model($user, array('url'=>'roles/'.$user->id, 'method'=>'PUT', 'class'=>'form-horizontal'))!!}
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nombre</label>
        <div class="col-sm-10">
            <h4>{!! $user->name !!}</h4>
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Role</label>
        <div class="col-sm-10">
            {!! Form::select('role', array(2 => 'Conductor', 3 => 'Contador'), old('role') !== null ? old('role') : $user->roles->isEmpty() ? null : $user->roles->first()->id, array('class'=>'form-control', 'placeholder' => 'Seleccione un rol...', 'required'=>'true')) !!}
        </div>
    </div>

    <div class="col-md-3 pull-right">
        <button class="btn btn-lg btn-success btn-block" type="submit">Enviar</button>
    </div>
    <div class="col-md-3 pull-right">
        <a class="btn btn-lg btn-danger btn-block" href="{!! url('roles') !!}">Cancelar</a>
    </div>
    {!! Form::close() !!}
@endsection