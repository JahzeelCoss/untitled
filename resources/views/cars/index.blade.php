@extends('layout.base')
@section('container')
    <h1 class="page-header">Vehículos <a class="btn btn-primary" href="{!! url('cars/create') !!}">Añadir</a></h1>
    {!!Notification::showAll()!!}
    @if(!$cars->isEmpty())
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Marca</th>
                <th>Descripción</th>
                <th>Placas</th>
                <th>Rendimiento</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cars as $car)
            <tr>
                <td>{!! $car->id !!}</td>
                <td>{!! $car->brand !!}</td>
                <td>{!! $car->description !!}</td>
                <td>{!! $car->plates !!}</td>
                <td>{!! $car->km_liter !!} Km/litro</td>
                <td>
                    <a class="btn btn-sm btn-warning" href="{!! url('cars/'.$car->id.'/edit') !!}">Editar</a>
                    <button data-id="{!!$car->id!!}" type="button" class="delete-tournament btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-car">
                        Eliminar
                    </button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    No hay vehículo registrados
    @endif
@endsection

<div class="modal fade" id="modal-delete-car" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Eliminar</h4>
            </div>
            {!! Form::open(array('url'=>'location', 'id'=>'delete-car-form', 'method' => 'DELETE')) !!}
            <div class="modal-body">
                <div class="container">
                    ¿Esta seguro que desea eliminar este vehículo?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-danger" type="submit">Eliminar</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@section('js')
    @parent
    <script type="text/javascript">
        $('#modal-delete-car').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('id');
            var modal = $(this);
            var url = '{!! route("cars.destroy", ":id") !!}';
            url = url.replace(':id', recipient);
            modal.find('.modal-content #delete-car-form').attr('action', url);
        })
    </script>
@endsection