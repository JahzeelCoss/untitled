@extends('layout.base')
@section('head')
    {!! Html::style('lib/select2/select2.min.css') !!}
    {!! Html::style('lib/datepicker/datetimepicker.min.css') !!}
@endsection
@section('container')
    @if(isset($travel))
        <h1 class="page-header">Editar Viaje #{!! $travel->id !!}</h1>
    @else
        <h1 class="page-header">Crear Viaje</h1>
    @endif

    {!!Notification::showAll()!!}
    @include('layout.formerror')
    <div class="row">
        <div class="col-md-3 pull-right">
            <button class="btn btn-lg btn-success btn-block" id="send-travel-btn">Enviar</button>
        </div>
        <div class="col-md-3 pull-right">
            <a class="btn btn-lg btn-danger btn-block" href="{!! url('travels') !!}">Cancelar</a>
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Vehículo</label>
        <div class="col-sm-10">
            <div class="select2-wrapper">
                <select id="car" name="car" class="select-car" style="width: 100%" required>
                    @if(isset($travel))
                        <option value="{!! $travel->car->id!!}" selected="selected">{!! 'Marca: '.$travel->car->brand.' - Descripción: '.$travel->car->description.' - Placas: '.$travel->car->plates!!}</option>
                    @endif
                </select>
            </div>
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Fecha del Viaje</label>
        <div class="col-sm-10">
            <input type='text' class="form-control" id='travel_date' required/>
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Motivo</label>
        <div class="col-sm-10">
            {!! Form::textarea('reason',  isset($travel) ? $travel->reason : "", array('class'=>'form-control', 'placeholder'=>'Motivo del viaje', 'required'=>'true', 'rows'=>'3', 'id'=>'reason')) !!}
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Observaciones</label>
        <div class="col-sm-10">
            {!! Form::textarea('observations', isset($travel) ? $travel->observations : "", array('class'=>'form-control', 'placeholder'=>'Detalles o comentarios especiales', 'rows'=>'3','id'=>'observations')) !!}
        </div>
    </div>
    <br>
    <div class="col-md-2">
        <p>Distancia Total</p>
    </div>
    <div class="col-md-4">
        <input id="total-distance-input" type="number" value="{!! isset($travel) ? $travel->total_distance : 0 !!}" disabled> Km.
    </div>
    <button type="button" class="btn btn-primary" id="add-route-btn">
        <span class="glyphicon glyphicon-plus"></span> Añadir nueva ruta
    </button>

    <table class="table table-condensed table-striped table-hover" id="travel-table">
        <thead>
        <tr>
            <th>Origen</th>
            <th>Destino</th>
            <th>Distancia (Km)</th>
            <th>Opciones</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($travel))
            <?php $counter =  0?>
            @foreach($travel->travelDetails as $detail)
                <tr id="row_{!! $counter !!}" route-id="{!! $detail->route->id  !!}">
                    <td class="origin-cell"><select name="origin" class="select-location" style="width: 80%" required>
                            <option value="{!! $detail->route->origin_location_id!!}" selected="selected">{!! $detail->route->origin_location->name!!}</option>
                        </select></td>
                    <td class="destination-cell"><select name="destination" class="select-location" style="width: 80%" required>
                            <option value="{!! $detail->route->destination_location_id!!}" selected="selected">{!! $detail->route->destination_location->name!!}</option>
                        </select></td>
                    <td class="distance-cell"><input type="number" value="{!! $detail->route->distance !!}" disabled></td>
                    <td><button type="button" class="btn btn-xs btn-danger delete-row-btn"><span class="glyphicon glyphicon-plus"></span> Eliminar</button></td>
                </tr>
                <?php $counter += 1 ?>
            @endforeach
        @endif
        </tbody>
    </table>
@endsection


<div class="modal fade" id="modal-alert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Advertencia</h4>
            </div>
            <div class="modal-body">
                <p>No puede seleccionar la misma ciudad como origen/destino</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-alert-novalue">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Advertencia</h4>
            </div>
            <div class="modal-body">
                <p>Todas las rutas deben tener su distancia registrada, por favor verifique la información y vuelva a intentar</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="error-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Advertencia</h4>
            </div>
            <div class="modal-body">
                <p>Los campos vehículo, fecha y motivo no pueden estar vacios</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@section('js')
    @parent
    {!! Html::script('lib/select2/select2.min.js') !!}
    {!! Html::script('lib/datepicker/moment.min.js') !!}
    {!! Html::script('lib/datepicker/datetimepicker.min.js') !!}
    @if(isset($travel))
        <script type="text/javascript">
            $(function () {
                $('#travel_date').datetimepicker({
                    format: 'D/MM/YYYY',
                    date: '{!! $travel->travel_date !!}'
                });
            });
        </script>
    @else
        <script type="text/javascript">
            $(function () {
                $('#travel_date').datetimepicker({
                    format: 'D/MM/YYYY'
                });
            });
        </script>
    @endif
    <script type="text/javascript">
        var rowCount = parseInt("{!! isset($travel) ? $travel->travelDetails->count()-1 : 0 !!}");
        $(document).on("click", "#add-route-btn", function () {
            $('#travel-table > tbody:last').append('<tr id="row_'+rowCount+
                    '"><td class="origin-cell"><select name="origin" class="select-location" style="width: 80%" required></select></td>' +
                    '<td class="destination-cell"><select name="destination" class="select-location" style="width: 80%" required></select></td>' +
                    '<td class="distance-cell"><input type="number" value="0" disabled></td>'+
                    '<td><button type="button" class="btn btn-xs btn-danger delete-row-btn"><span class="glyphicon glyphicon-plus"></span> Eliminar</button></td>' +
                    '</tr>');
            $(".select-location").select2({
                placeholder: "Seleccione una localidad",
                ajax: {
                    url: "{!! url('routes/searchlocation') !!}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            name: params.term // search term
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
            });
            rowCount = rowCount + 1;
        });

        $(".select-location").select2({
            placeholder: "Seleccione una localidad",
            ajax: {
                url: "{!! url('routes/searchlocation') !!}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        name: params.term // search term
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
        });

        $(".select-car").select2({
            placeholder: "Seleccione un vehículo",
            ajax: {
                url: "{!! url('cars/searchcar') !!}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        name: params.term // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function(obj) {
                            return { id: obj.id, text: 'Marca: '+obj.brand+' - Descripción: '+obj.description+' - Placas: '+obj.plates };
                        })
                    };
                },
                cache: true,
            }
        });





        $(document).on('click', '.delete-row-btn', function () {
            var currentValue = $('#total-distance-input').val();
            var newValue = currentValue - parseInt($(this).closest('tr').find('input').val());
            $('#total-distance-input').val(newValue);
            $(this).closest('tr').remove();
        });
        $(document).on('click', '#send-travel-btn', function () {
            if($('#reason').val() == "" || $('#reason').val() == null || $('#travel_date').val() == "" || $('#travel_date').val() == null
                    || $('#car').val() == "" || $('#car').val() == null){
                $('#error-modal').modal('show')
                return;
            }
            var currentValue = parseInt($('#total-distance-input').val());
            if(currentValue !== 0){
                var distanceCells = $('#travel-table tbody').find('td.distance-cell');
                var routes = new Array();
                for(var i = 0; i < distanceCells.length; i++){
                    if(parseInt($(distanceCells[i]).find('input').val()) === 0){
                        $("#modal-alert-novalue").modal('show');
                        return;
                    }else{
                        var parentRow = $(distanceCells[i]).closest('tr');
                        var routeObj = {
                            id: parseInt(parentRow.attr('route-id'))
                        }
                        routes.push(routeObj);
                    }
                }
                $post = {
                    driver_id: "{!! Auth::user()->id !!}",
                    car_id: $('#car').val(),
                    date: $('#travel_date').val(),
                    reason: $('#reason').val(),
                    observations: $('#observations').val(),
                    total_distance: currentValue,
                    routes: routes,
                    _token: "{!!csrf_token()!!}"
                };
                $.ajax({
                    url: "{!!isset($travel) ? url('travels/'.$travel->id) : url('/travels') !!}",
                    type: "{!!isset($travel) ? "PUT" : "POST" !!}",
                    data: $post,
                    success: function(data){
                        window.location.href = "{!! url('travels') !!}";
                    },
                    error: function(error){
                        alert('Ha ocurrdio un error. Verifique los datos colocados e intente más tarde');
                    }
                });
            }else{
                $("#modal-alert-novalue").modal('show');
            }
        });
        $(document).on('change', '.select-location', function () {
            var inputDistance = $(this).closest('tr').find('input');
            var parentRow = $(this).closest('tr');
            if($(this).closest('select').attr('name') === 'origin'){
                var originValue = $(this).val();
                var destinationValue = $(this).closest('td').next().find('select').val();
                if(destinationValue !== null && originValue !== destinationValue){
                    var $post = {};
                    $post.origin = originValue;
                    $post.destination = destinationValue;
                    $post._token = "{!!csrf_token()!!}";
                    $.ajax({
                        url: "{!!url('routes/searchroute')!!}",
                        type: 'POST',
                        data: $post,
                        success: function(data){
                            setRouteData(data, inputDistance, parentRow);
                        }
                    });
                }else if(originValue === destinationValue){
                    $("#modal-alert").modal('show');
                }
            }else{
                var destinationValue = $(this).val();
                var originValue = $(this).closest('td').prev().find('select').val();
                if(originValue !== null && originValue !== destinationValue){
                    var $post = {};
                    $post.origin = originValue;
                    $post.destination = destinationValue;
                    $post._token = "{!!csrf_token()!!}";
                    $.ajax({
                        url: "{!!url('routes/searchroute')!!}",
                        type: 'POST',
                        data: $post,
                        success: function(data){
                            setRouteData(data, inputDistance, parentRow);
                        }
                    });
                }else if(originValue === destinationValue){
                    $("#modal-alert").modal('show');
                }
            }
        });
        function setRouteData(data, inputDistance, parentRow){
            var routeInfo = data;
            if(!$.isEmptyObject(routeInfo)){
                inputDistance.val(routeInfo.distance);
                updateTotalDistance();
                parentRow.attr('route-id', routeInfo.id);
            }else{
                inputDistance.val(0);
            }
        }
        function updateTotalDistance(){
            var distanceCells = $('#travel-table tbody').find('td.distance-cell');
            var sum = 0;
            for(var i = 0; i < distanceCells.length; i++){
                sum += parseFloat($(distanceCells[i]).find('input').val());
            }
            $('#total-distance-input').val(sum);
        };
    </script>
@endsection