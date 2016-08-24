@extends('layout.base')
@section('container')
    <h1 class="page-header">Precio Gasolina</h1>
    @if($gas != null)
        <h3>Precio Actual ${!! $gas->price !!} por litro</h3>
    @else
        <h3>No se ha colocado el precio aun</h3>
    @endif
    <br>
    {!!Notification::showAll()!!}
    @include('layout.formerror')
    @if(isset($gas))
        {!!Form::model($gas, array('url'=>'gas/'.$gas->id, 'method'=>'PUT', 'class'=>'form-horizontal'))!!}
    @else
        {!!Form::open(array('url' => 'gas', 'class'=>'form-horizontal'))!!}
    @endif
    <div class="form-group">
        <label for="price" class="col-sm-2 control-label">Precio por litro</label>
        <div class="col-sm-10">
            {!! Form::number('price', old('price'), array('class'=>'form-control', 'placeholder'=>'Precio Actual de la gasolina', 'step'=>'any','min'=>'0','required'=>'true')) !!}
        </div>
    </div>

    <div class="col-md-3 pull-right">
        <button class="btn btn-lg btn-success btn-block" type="submit">Enviar</button>
    </div>
    {!! Form::close() !!}
@endsection
