@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reservas por dia</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ route('reservations_by_day.pdf', [request('date') ? request('date') : now()->format('d-m-Y'), request('stadium_id') ? request('stadium_id') : $stadiums->first()->id]) }}"
                            class="btn btn-sm btn-success"><i class="fa fa-print"></i> Imprimir</a>
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
                        <div class="card-header">
                            <h3 class="card-title">Consultar</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date">Fecha</label>
                                        <input name="date" id="datepicker" autocomplete="off"
                                            value="{{ request('date') ? request('date') : now()->format('d-m-Y') }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="stadium">Cancha</label>
                                        <select name="stadium" id="select_stadium_id" class="form-control">
                                            @foreach ($stadiums as $stadium)
                                                <option value="{{ $stadium->id }}"
                                                    {{ request('stadium_id') ? (request('stadium_id') == $stadium->id ? 'selected' : '') : '' }}>
                                                    {{ $stadium->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-12">
                                    {!! $table !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <form action="#" method="POST" id="change-state-form" style="display: none;">
        @csrf
        <input type="hidden" name="state" id="state" value="#">
    </form>

    @include('backend.sections.reservations.detail-change-state')
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#datepicker').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                iconsLibrary: 'fontawesome'
            });

            var lastDatepickerSelected = $('#datepicker').val();
            $('#datepicker').change(function(e) {
                if (lastDatepickerSelected !== e.target.value) {
                    $('.lds-roller').css('display', 'block');
                    window.location.href = route('reservations_by_day.index', [$(this).val(), $(
                        '#select_stadium_id').val()]);
                }
            });

            $('#select_stadium_id').change(function() {
                $('.lds-roller').css('display', 'block');
                window.location.href = route('reservations_by_day.index', [$('#datepicker').val(), $(this)
                    .val()
                ]);
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
                    $('#detail_reservation_id').val(id);
                    $('#detail_reservation_state').val(response['reservation']['state']);
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

            $('#detail_reservation_state').change(function() {
                let id = $('#detail_reservation_id').val();
                let state = $(this).val();
                let url = route('reservations.change_state', id);
                $('#change-state-form').attr('action', url);
                $('#state').val(state);
                $('#change-state-form').submit();
                $('#detailModal').modal('hide');
            });
        });
    </script>
@endsection
