@extends('layout.base')
@section('container')
    @if(isset($car))
        <h1 class="page-header">Editar Veículo</h1>
    @else
        <h1 class="page-header">Añadir Veículo</h1>
    @endif

    {!!Notification::showAll()!!}
    @include('layout.formerror')
    @if(isset($car))
        {!!Form::model($car, array('url'=>'cars/'.$car->id, 'method'=>'PUT', 'class'=>'form-horizontal'))!!}
    @else
        {!!Form::open(array('url' => 'cars', 'class'=>'form-horizontal'))!!}
    @endif
    <div class="form-group">
        <label for="brand" class="col-sm-2 control-label">Marca</label>
        <div class="col-sm-10">
            {!! Form::text('brand', old('brand'), array('class'=>'form-control', 'placeholder'=>'Nissan, Honda, Toyota, etc', 'required'=>'true')) !!}
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Descripción</label>
        <div class="col-sm-10">
            {!! Form::textarea('description', old('description'), array('class'=>'form-control', 'placeholder'=>'Cilindros, motor, caracteristicas especiales', 'required'=>'true', 'rows'=>'3')) !!}
        </div>
    </div>

    <div class="form-group">
        <label for="plates" class="col-sm-2 control-label">Placas</label>
        <div class="col-sm-10">
            {!! Form::text('plates', old('plates'), array('class'=>'form-control', 'placeholder'=>'Placas del veiculo', 'required'=>'true')) !!}
        </div>
    </div>

    <div class="form-group">
        <label for="km_liter" class="col-sm-2 control-label">Rendimiento</label>
        <div class="col-sm-10">
            {!! Form::number('km_liter', old('km_liter'), array('class'=>'form-control', 'placeholder'=>'Cantidad de Kilometros por Litro que rinde el veículo', 'required'=>'true', 'step'=>'any', 'min'=>'0')) !!}
        </div>
    </div>

    <div class="col-md-3 pull-right">
        <button class="btn btn-lg btn-success btn-block" type="submit">Enviar</button>
    </div>
    <div class="col-md-3 pull-right">
        <a class="btn btn-lg btn-danger btn-block" href="{!! url('cars') !!}">Cancelar</a>
    </div>
    {!! Form::close() !!}
@endsection