@extends('layout.base')
@section('container')
    <h1 class="page-header">Viajes</h1>
    {!!Notification::showAll()!!}
    @if(!$travels->isEmpty())
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>

                    <th>Fecha del Viaje</th>
                    <th>Conductor</th>
                    <th>Ultimo Contador en cambiar de estado</th>
                    <th>Distancia Total</th>
                    <th>Costo estimado</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($travels as $travel)
                    <tr>
                        <td>{!! $travel->id !!}</td>
                        <td>{!! $travel->travel_date !!}</td>
                        <td>{!! $travel->driver->name !!}</td>
                        @if($travel->accountant != null)
                            <td>{!! $travel->accountant->name !!}</td>
                        @else
                            <td>No asignado</td>
                        @endif
                        <td>{!! $travel->total_distance !!} Km</td>
                        <td>${!! $travel->estimate_cost !!} </td>
                        <td>{!! $travel->getStatus() !!}</td>
                        <td>
                            <a class="btn btn-xs btn-primary" href="{!! url('travels/'.$travel->id) !!}"><span class="glyphicon glyphicon-eye-open"></span>Ver</a>
                            <div class="btn-group">
                                <button type="button" class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="glyphicon glyphicon-flag"></span> Cambiar Estado <span class="fa fa-caret-down"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{!!url('travels/changestatus/0/'.$travel->id)!!}">No Aprobado</a></li>
                                    <li><a href="{!!url('travels/changestatus/1/'.$travel->id)!!}">Pendiente</a></li>
                                    <li><a href="{!!url('travels/changestatus/2/'.$travel->id)!!}">Aprobado</a></li>
                                </ul>
                            </div>
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
@section('js')
    @parent
    {{--<script type="text/javascript">--}}
        {{--$('#modal-delete-travel').on('show.bs.modal', function (event) {--}}
            {{--var button = $(event.relatedTarget);--}}
            {{--var recipient = button.data('id');--}}
            {{--var modal = $(this);--}}
            {{--var url = '{!! route("travels.destroy", ":id") !!}';--}}
            {{--url = url.replace(':id', recipient);--}}
            {{--modal.find('.modal-content #delete-travel-form').attr('action', url);--}}
        {{--})--}}
    {{--</script>--}}
@endsection