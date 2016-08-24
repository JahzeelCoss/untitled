@extends('layout.base')
@section('container')
    <h1 class="page-header">Roles </h1>
    {!!Notification::showAll()!!}
    @if(!$users->isEmpty())
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            @if(!$user->hasRole('admin'))
            <tr>
                <td>{!! $user->id !!}</td>
                <td>{!! $user->name !!}</td>
                @if($user->roles->isEmpty())
                <td>Sin Rol Asignado</td>
                @else
                <td>{!! $user->roles->first()->display_name !!}</td>
                @endif
                <td>
                    <a class="btn btn-sm btn-warning" href="{!! url('roles/'.$user->id.'/edit') !!}">Editar</a>
                    {{--<button data-id="{!!$user->id!!}" type="button" class="delete-tournament btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-location">--}}
                        {{--Eliminar--}}
                    {{--</button>--}}
                </td>
            </tr>
            @endif
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    No hay usuarios registrados
    @endif
@endsection

{{--<div class="modal fade" id="modal-delete-location" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
    {{--<div class="modal-dialog">--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>--}}
                {{--<h4 class="modal-title">Eliminar</h4>--}}
            {{--</div>--}}
            {{--{!! Form::open(array('url'=>'location', 'id'=>'delete-location-form', 'method' => 'DELETE')) !!}--}}
            {{--<div class="modal-body">--}}
                {{--<div class="container">--}}
                    {{--¿Esta seguro que desea eliminar esta localidad?--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>--}}
                {{--<button class="btn btn-danger" type="submit">Eliminar</button>--}}
            {{--</div>--}}
            {{--{!!Form::close()!!}--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--@section('js')--}}
    {{--@parent--}}
    {{--<script type="text/javascript">--}}
        {{--$('#modal-delete-location').on('show.bs.modal', function (event) {--}}
            {{--var button = $(event.relatedTarget);--}}
            {{--var recipient = button.data('id');--}}
            {{--var modal = $(this);--}}
            {{--var url = '{!! route("locations.destroy", ":id") !!}';--}}
            {{--url = url.replace(':id', recipient);--}}
            {{--modal.find('.modal-content #delete-location-form').attr('action', url);--}}
        {{--})--}}
    {{--</script>--}}
{{--@endsection--}}