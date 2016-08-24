@extends('layout.base')
@section('container')
    <h1 class="page-header">Viajes <a class="btn btn-primary" href="{!! url('travels/create') !!}">Añadir</a></h1>
    {!!Notification::showAll()!!}
    @if(Session::has('success_msg'))

        <div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            {!! Session::get('success_msg') !!}
        </div>
    @endif
    @if(!$travels->isEmpty())
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha del Viaje</th>
                    <th>Distancia Total</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($travels as $travel)
                    <tr>
                        <td>{!! $travel->id !!}</td>
                        <td>{!! $travel->travel_date !!}</td>
                        <td>{!! $travel->total_distance !!} Km</td>
                        <td>{!! $travel->getStatus() !!}</td>
                        <td>
                            <a class="btn btn-xs btn-primary" href="{!! url('travels/'.$travel->id) !!}"><span class="glyphicon glyphicon-eye-open"></span> Ver</a>
                            @if($travel->status == 1)
                            <a class="btn btn-xs btn-warning" href="{!! url('travels/'.$travel->id.'/edit') !!}"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
                            <button data-id="{!!$travel->id!!}" type="button" class="delete-tournament btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-delete-travel">
                                <span class="glyphicon glyphicon-remove"></span> Eliminar
                            </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        No hay viajes programados
    @endif
@endsection

<div class="modal fade" id="modal-delete-travel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Eliminar</h4>
            </div>
            {!! Form::open(array('url'=>'travels', 'id'=>'delete-travel-form', 'method' => 'DELETE')) !!}
            <div class="modal-body">
                <div class="container">
                    ¿Esta seguro que desea eliminar este viaje?
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
        $('#modal-delete-travel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('id');
            var modal = $(this);
            var url = '{!! route("travels.destroy", ":id") !!}';
            url = url.replace(':id', recipient);
            modal.find('.modal-content #delete-travel-form').attr('action', url);
        })
    </script>
@endsection