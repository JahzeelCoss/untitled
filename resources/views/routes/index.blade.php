@extends('layout.base')
@section('container')
    <h1 class="page-header">Rutas <a class="btn btn-primary" href="{!! url('routes/create') !!}">Añadir</a></h1>
    {!!Notification::showAll()!!}
    @if(!$routes->isEmpty())
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Distancia</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($routes as $route)
            <tr>
                <td>{!! $route->id !!}</td>
                <td>{!! $route->origin_location->town." - ".$route->origin_location->name !!}</td>
                <td>{!! $route->destination_location->town." - ".$route->destination_location->name !!}</td>
                <td>{!! $route->distance !!}</td>
                <td>
                    <a class="btn btn-sm btn-warning" href="{!! url('routes/'.$route->id.'/edit') !!}">Editar</a>
                    <button data-id="{!!$route->id!!}" type="button" class="delete-tournament btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-route">
                        Eliminar
                    </button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    No hay rutas registradas
    @endif
@endsection

<div class="modal fade" id="modal-delete-route" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Eliminar</h4>
            </div>
            {!! Form::open(array('url'=>'location', 'id'=>'delete-route-form', 'method' => 'DELETE')) !!}
            <div class="modal-body">
                <div class="container">
                    ¿Esta seguro que desea eliminar esta ruta?
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
        $('#modal-delete-route').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('id');
            var modal = $(this);
            var url = '{!! route("routes.destroy", ":id") !!}';
            url = url.replace(':id', recipient);
            modal.find('.modal-content #delete-route-form').attr('action', url);
        })
    </script>
@endsection