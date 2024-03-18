@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reservas</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('reservations.create') }}"><i class="fa fa-plus"></i>
                            Ingresar reserva</a>
                        <a class="btn btn-sm btn-success" href="{{ route('reservations.create_fixed') }}"><i
                                class="fa fa-plus"></i> Ingresar reserva fija</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Filtrar datos</h3>
                                </div>

                                <div class="card-body">
                                    <form>
                                        <div class="row">

                                            <div class="col-sm-6">

                                                <div class="form-group">
                                                    <label for="filter_year">Año</label>
                                                    <select name="filter_year" id="filter_year" class="form-control">
                                                        @foreach ($years as $year)
                                                            <option {{ $year == now()->year ? 'selected' : '' }}
                                                                value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered nowrap" style="width: 100%;" id="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cliente</th>
                                            <th>Medio Pago</th>
                                            <th>Cancha</th>
                                            <th>Fecha</th>
                                            <th>Abonado</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <form action="#" method="POST" id="delete-form" style="display: none;">
        @method('DELETE')
        @csrf
    </form>

    <form action="#" method="POST" id="change-state-form" style="display: none;">
        @csrf
        <input type="hidden" name="state" id="state" value="#">
    </form>

    @include('backend.sections.reservations.detail')
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: route('reservations.index'),
                    data: function(d) {
                        d.filter_year = $('#filter_year').val();
                    }
                },
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json"
                },
                columnDefs: [{
                    render: function(data) {
                        return moment(data).format('DD-MM-YYYY');
                    },
                    targets: 4
                }],
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'user_name',
                        name: 'users.name'
                    },
                    {
                        data: 'payment_media',
                        name: 'payment_media'
                    },
                    {
                        data: 'stadium_name',
                        name: 'stadiums.name'
                    },
                    {
                        data: 'reservation_date',
                        name: 'reservation_items.date'
                    },
                    {
                        data: 'advancement',
                        name: 'advancement'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'changeStateButton',
                        name: 'changeStateButton',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ],
                order: [
                    [4, 'desc']
                ]
            });

            $('#filter_year').change(function() {
                var oTable = $('#table').dataTable();
                oTable.fnDraw(false);
            });

            $('#table tbody').on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                let url = route('reservations.destroy', id);
                $('#delete-form').attr('action', url);

                Swal.fire({
                    title: '¿Eliminar este registro?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si, eliminalo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form').submit();
                    }
                });
            });

            $('#table').on('click', '.dropdown-state', function() {
                let id = $(this).data('id');
                let state = $(this).data('state');
                let url = route('reservations.change_state', id);
                $('#change-state-form').attr('action', url);
                $('#state').val(state);

                Swal.fire({
                    title: '¿Cambiar estado?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si, cambialo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#change-state-form').submit();
                    }
                });
            });

            $('#table').on('click', '.btn-detail', function() {
                let id = $(this).data('id');
                let url = route('reservations.detail', id);

                $.get(url, function(response) {
                    $('#detail_user_name').html('<strong>Nombre: </strong>' + response[
                        'reservation']['user_name']);
                    $('#detail_user_rut').html('<strong>RUT: </strong>' + response['reservation'][
                        'user_rut'
                    ]);
                    $('#detail_user_phone').html('<strong>Fono: </strong>' + response['reservation']
                        ['user_phone']);
                    $('#detail_stadium_name').html('<strong>Cancha: </strong>' + response[
                        'reservation']['stadium_name']);
                    $('#detail_reservation_payment_media').html('<strong>Medio Pago: </strong>' +
                        response['reservation']['payment_media']);
                    $('#detail_reservation_state').html('<strong>Estado reserva: </strong>' +
                        response['reservation']['state']);
                    $('#detail_tbody_hours').html(`${response['reservationItems'].map(function (reservationItem) {
                        return "<tr><td width='50%'>"+moment(reservationItem.date).format('DD-MM-YYYY')+"</td><td width='50%'>"+reservationItem.hour+"</td></tr>"
                    }).join('')}`);
                    $('#detail_discount').html('<strong>Descuento Aplicado: </strong>' + response[
                        'discountFormatted']);
                    $('#detail_advancement').html('<strong>Abonado: </strong>' + response[
                        'advancementFormatted']);
                    $('#detail_total').html('<strong>Total: </strong>' + response[
                        'totalFormatted']);

                    $('#detailModal').modal('show');
                });
            });
        });
    </script>
@endsection
