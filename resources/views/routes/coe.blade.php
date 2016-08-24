@extends('layout.base')
@section('head')
{!! Html::style('lib/select2/select2.min.css') !!}
@endsection
@section('container')
    @if(isset($route))
        <h1 class="page-header">Editar Ruta</h1>
    @else
        <h1 class="page-header">Añadir Ruta</h1>
    @endif

    {!!Notification::showAll()!!}
    @include('layout.formerror')
    @if(isset($route))
        {!!Form::model($route, array('url'=>'routes/'.$route->id, 'method'=>'PUT', 'class'=>'form-horizontal'))!!}
    @else
        {!!Form::open(array('url' => 'routes', 'class'=>'form-horizontal'))!!}
    @endif
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Origen</label>
        <div class="col-sm-10">
            <div class="select2-wrapper">
                <select id="origin_location_id" name="origin_location_id" class="select-location" style="width: 100%" required>
                    @if(old('origin_location_id') != null)
                    <option value="{!! old('origin_location_id') !!}" selected="selected">{!! \App\Location::where('id','=', old('origin_location_id'))->value('name') !!}</option>
                    @else
                        @if(isset($route))
                            <option value="{!! $route->origin_location_id!!}" selected="selected">{!! $route->origin_location->name!!}</option>
                        @endif
                    @endif
                </select>

            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Destino</label>
        <div class="col-sm-10">
            <div class="select2-wrapper">
                <select id="destination_location_id" name="destination_location_id" class="select-location" style="width: 100%" required>
                    @if(old('destination_location_id') != null)
                        <option value="{!! old('destination_location_id') !!}" selected="selected">{!! \App\Location::where('id','=', old('destination_location_id'))->value('name') !!}</option>
                    @else
                        @if(isset($route))
                            <option value="{!! $route->destination_location_id!!}" selected="selected">{!! $route->destination_location->name!!}</option>
                        @endif
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Distancia</label>
        <div class="col-sm-10">
            {!! Form::number('distance', old('distance'), array('class'=>'form-control', 'placeholder'=>'Distancia en Km', 'step'=>'any','min'=>'0','required'=>'true')) !!}
        </div>
    </div>
    @if(!isset($route))
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Crear ruta inversa</label>
        <div class="col-sm-10">
            {!! Form::checkbox('reverse', old('reverese'), true) !!}
        </div>
    </div>
    @endif

    <div class="col-md-3 pull-right">
        <button class="btn btn-lg btn-success btn-block" type="submit">Enviar</button>
    </div>
    <div class="col-md-3 pull-right">
        <a class="btn btn-lg btn-danger btn-block" href="{!! url('routes') !!}">Cancelar</a>
    </div>
    {!! Form::close() !!}
@endsection
@section('js')
    @parent
    {!! Html::script('lib/select2/select2.min.js') !!}
    <script type="text/javascript">
        $(".select-location").select2({
            placeholder: "Seleccione una localidad",
            ajax: {
                url: "{!! url('routes/searchlocation') !!}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        name: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function(obj) {
                            return { id: obj.id, text: obj.town + " - " +obj.name };
                        })
                    };
                },
                cache: true
            }
        }).attr('style','display:block; position:absolute; bottom: 0; left: 0; clip:rect(0,0,0,0);');
    </script>
@endsection