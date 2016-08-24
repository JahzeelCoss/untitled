@extends('layout.base')
@section('head')
    {!! Html::style('lib/select2/select2.min.css') !!}
    {!! Html::style('lib/datepicker/datetimepicker.min.css') !!}
@endsection
@section('container')
    <h1 class="page-header">Reportes</h1>
    <div >        
        <form method="POST">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Fecha Inicial</label>
                <div class="col-sm-3">
                    <input type='text' class="form-control" name="startingDate" id='startingDate' required/>
                </div>
            </div> 
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Fecha Final</label>
                <div class="col-sm-3">
                    <input type='text' class="form-control" name="finalDate" id='finalDate' required/>
                </div>
            </div>  
            <div class="form-group">               
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-default">Buscar</button>
                </div>
            </div> 
        </form>  
    </div>
    <hr>
    &nbsp;
    @if(isset($data) && !$data['travels']->isEmpty())
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha del Viaje</th>
                    <th>Distancia</th>
                    <th>Costo</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['travels'] as $travel)
                    <tr>
                        <td>{!! $travel->id !!}</td>
                        <td>{!! $travel->travel_date !!}</td>
                        <td>{!! $travel->total_distance !!} Km</td>
                        <td>$ {!! $travel->estimate_cost !!} </td>
                        <td>{!! $travel->getStatus() !!}</td>
                        <td>
                            <a class="btn btn-xs btn-primary" href="{!! url('travels/'.$travel->id) !!}"><span class="glyphicon glyphicon-eye-open"></span> Ver</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th># de Viajes</th>
                    <th>Distancia Total</th>
                    <th>Costo Total</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{!! $data['numberOfTravels'] !!}</td>
                        <td>{!! $data['totalDistance']  !!} km</td>
                        <td>$ {!! $data['totalCost']  !!}</td>
                        <td>
                            @if(Entrust::hasRole('admin') || Entrust::hasRole('accountant'))
                                {!! Form::open(array('url' => 'reports/excel', 'class' => 'pull-right', 
                                'action' => 'ReportGeneratorController@excel' )) !!}
                                {!! csrf_field() !!}
                                <input type="hidden" name="startingDate" value="{{ $data['startingDate'] }}" />
                                <input type="hidden" name="finalDate" value="{{ $data['finalDate'] }}" />
                                {!! Form::submit('Generar Excel', array('class' => 'btn btn-xs btn-danger hidden-print',)) !!}
                                {!! Form::close() !!}                            
                            @endif                              
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
@endsection


@section('js')
    @parent
    {!! Html::script('lib/select2/select2.min.js') !!}
    {!! Html::script('lib/datepicker/moment.min.js') !!}
    {!! Html::script('lib/datepicker/datetimepicker.min.js') !!}

    @if(isset($data) && !$data['travels']->isEmpty())
        <script type="text/javascript">
            $(function () {
                $('#startingDate').datetimepicker({
                    format: 'YYYY/MM/DD',
                    date: "{!! $data['startingDate'] !!}"
                });
                $('#finalDate').datetimepicker({
                    format: 'YYYY/MM/DD',
                    date: "{!! $data['finalDate'] !!}"
                });
            });
        </script>
    @else
        <script type="text/javascript">
            $(function () {
                $('#startingDate').datetimepicker({
                    format: 'YYYY/MM/DD',                                    
                });
                 $('#finalDate').datetimepicker({
                    format: 'YYYY/MM/DD',                    
                });
            });
        </script>
    @endif
     

    <script type="text/javascript">
        $(function () {
            $('#startingDate').datetimepicker({
                useCurrent: false,                
            });
            $('#finalDate').datetimepicker({
                useCurrent: true                 
            });
            $("#startingDate").on("dp.change", function (e) {
                $('#finalDate').data("DateTimePicker").minDate(e.date);
            });
            $("#finalDate").on("dp.change", function (e) {
                $('#startingDate').data("DateTimePicker").maxDate(e.date);
            });
        });
    </script>

    
@endsection