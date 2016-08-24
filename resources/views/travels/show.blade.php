@extends('layout.base')
@section('container')
    <h1 class="page-header"><span class="hidden-print">Mostrando</span> Viaje #{!! $travel->id !!}</h1>

    {!!Notification::showAll()!!}
    @include('layout.formerror')
    <div class="row">
        <div class="col-md-3 pull-right">
            <a class="btn btn-lg btn-primary btn-block hidden-print" href="{!! url('travels') !!}">Cerrar</a>
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Fecha del Viaje</label>
        <div class="col-sm-10">
            <input type='text' class="form-control" id='travel_date' disabled value="{!! $travel->travel_date !!}"/>
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Motivo</label>
        <div class="col-sm-10">
            {!! Form::textarea('reason',  isset($travel) ? $travel->reason : "", array('class'=>'form-control','rows'=>'3', 'disabled'=>'true')) !!}
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Observaciones</label>
        <div class="col-sm-10">
            {!! Form::textarea('observations', isset($travel) ? $travel->observations : "", array('class'=>'form-control','rows'=>'3', 'disabled'=>'true')) !!}
        </div>
    </div>
    <div class="col-md-2">
        <p>Distancia Total</p>
    </div>
    <div class="col-md-4">
        <input id="total-distance-input" type="number" value="{!! isset($travel) ? $travel->total_distance : 0 !!}" disabled> Km.
    </div>

    <table class="table table-condensed table-striped table-hover" id="travel-table">
        <thead>
        <tr>
            <th>Origen</th>
            <th>Destino</th>
            <th>Distancia (Km)</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($travel))
            <?php $counter =  0?>
            @foreach($travel->travelDetails as $detail)
                <tr id="row_{!! $counter !!}" route-id="{!! $detail->route->id  !!}">
                    <td>{!! $detail->route->origin_location->name!!}</td>
                    <td>{!! $detail->route->destination_location->name!!}</td>
                    <td>{!! $detail->route->distance !!}</td>
                </tr>
                <?php $counter += 1 ?>
            @endforeach
        @endif
        </tbody>
    </table>  
    @if(Entrust::hasRole('admin') || Entrust::hasRole('accountant'))
        {!! Form::open(array('url' => 'travels/' . $travel->id . '/excel', 'class' => 'pull-right', 'action' => 'TravelController@excel' )) !!}
        {!! Form::submit('Generar Excel', array('class' => 'btn btn-xs btn-danger hidden-print',)) !!}
        {!! Form::close() !!}
    |
    <a href='javascript:window.print(); void 0;' class="hidden-print btn btn-xs btn-info pull-right">Imprimir</a>  
    @endif  
    
@endsection