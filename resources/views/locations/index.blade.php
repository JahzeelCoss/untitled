@extends('layout.base')
@section('container')
    <h1 class="page-header">Localidades <a class="btn btn-primary" href="{!! url('locations/create') !!}">Añadir</a></h1>
    {!!Notification::showAll()!!}
    @if(!$locations->isEmpty())
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Municipio</th>
                <th>Nombre</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($locations as $location)
            <tr>
                <td>{!! $location->id !!}</td>
                <td>{!! $location->town !!}</td>
                <td>{!! $location->name !!}</td>
                <td>
                    <a class="btn btn-sm btn-warning" href="{!! url('locations/'.$location->id.'/edit') !!}">Editar</a>
                    <button data-id="{!!$location->id!!}" type="button" class="delete-tournament btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-location">
                        Eliminar
                    </button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    No hay localidades registradas
    @endif
@endsection

<div class="modal fade" id="modal-delete-location" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Eliminar</h4>
            </div>
            {!! Form::open(array('url'=>'location', 'id'=>'delete-location-form', 'method' => 'DELETE')) !!}
            <div class="modal-body">
                <div class="container">
                    ¿Esta seguro que desea eliminar esta localidad?
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
        $('#modal-delete-location').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('id');
            var modal = $(this);
            var url = '{!! route("locations.destroy", ":id") !!}';
            url = url.replace(':id', recipient);
            modal.find('.modal-content #delete-location-form').attr('action', url);
        })
    </script>
@endsection