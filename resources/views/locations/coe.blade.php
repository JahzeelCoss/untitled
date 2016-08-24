@extends('layout.base')
@section('container')
    @if(isset($location))
        <h1 class="page-header">Editar Localidad</h1>
    @else
        <h1 class="page-header">Añadir Localidad</h1>
    @endif

    {!!Notification::showAll()!!}
    @include('layout.formerror')
    @if(isset($location))
        {!!Form::model($location, array('url'=>'locations/'.$location->id, 'method'=>'PUT', 'class'=>'form-horizontal'))!!}
    @else
        {!!Form::open(array('url' => 'locations', 'class'=>'form-horizontal'))!!}
    @endif
    <div class="form-group">
        <label for="town" class="col-sm-2 control-label">Municipio</label>
        <div class="col-sm-10">
            {!! Form::text('town', old('town'), array('class'=>'form-control', 'placeholder'=>'Municipio al que pertenece la localidad', 'required'=>'true')) !!}
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nombre</label>
        <div class="col-sm-10">
            {!! Form::text('name', old('name'), array('class'=>'form-control', 'placeholder'=>'Nombre de la localidad', 'required'=>'true')) !!}
        </div>
    </div>

    <div class="col-md-3 pull-right">
        <button class="btn btn-lg btn-success btn-block" type="submit">Enviar</button>
    </div>
    <div class="col-md-3 pull-right">
        <a class="btn btn-lg btn-danger btn-block" href="{!! url('locations') !!}">Cancelar</a>
    </div>
    {!! Form::close() !!}
@endsection