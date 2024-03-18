@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pagos Suscripciones</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h4>Estudiantes activos <span class="badge badge-primary">{{ $studentsCount }}</span></h4>
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
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Filtrar datos</h3>
                                        </div>

                                        <div class="card-body">
                                            <form>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="filter_class">Escuela</label>
                                                            <select name="filter_class" id="filter_class"
                                                                class="form-control">
                                                                <option value="all" selected>Todos</option>
                                                                <option value="Menor Edad">Escuela de Fútbol</option>
                                                                <option value="Mayor Edad">Academia Calccio FC</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="filter_year">Año suscripcion</label>
                                                            <select name="filter_year" id="filter_year"
                                                                class="form-control">
                                                                @foreach ($years as $year)
                                                                    <option value="{{ $year }}"
                                                                        {{ $year == now()->year ? 'selected' : '' }}>
                                                                        {{ $year }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="filter_month">Mes suscripcion</label>
                                                            <select name="filter_month" id="filter_month"
                                                                class="form-control">
                                                                <option value="01"
                                                                    {{ now()->month == '01' ? 'selected' : '' }}>Enero
                                                                </option>
                                                                <option value="02"
                                                                    {{ now()->month == '02' ? 'selected' : '' }}>Febrero
                                                                </option>
                                                                <option value="03"
                                                                    {{ now()->month == '03' ? 'selected' : '' }}>Marzo
                                                                </option>
                                                                <option value="04"
                                                                    {{ now()->month == '04' ? 'selected' : '' }}>Abril
                                                                </option>
                                                                <option value="05"
                                                                    {{ now()->month == '05' ? 'selected' : '' }}>Mayo
                                                                </option>
                                                                <option value="06"
                                                                    {{ now()->month == '06' ? 'selected' : '' }}>Junio
                                                                </option>
                                                                <option value="07"
                                                                    {{ now()->month == '07' ? 'selected' : '' }}>Julio
                                                                </option>
                                                                <option value="08"
                                                                    {{ now()->month == '08' ? 'selected' : '' }}>Agosto
                                                                </option>
                                                                <option value="09"
                                                                    {{ now()->month == '09' ? 'selected' : '' }}>Septiembre
                                                                </option>
                                                                <option value="10"
                                                                    {{ now()->month == '10' ? 'selected' : '' }}>Octubre
                                                                </option>
                                                                <option value="11"
                                                                    {{ now()->month == '11' ? 'selected' : '' }}>Noviembre
                                                                </option>
                                                                <option value="12"
                                                                    {{ now()->month == '12' ? 'selected' : '' }}>Diciembre
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title" id="balance_title">Balance {{ now()->format('m-Y') }}
                                            </h3>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul class="list-group">
                                                        <li class="list-group-item" id="balance_total_payed"
                                                            style="padding: 5px;"></li>
                                                        <li class="list-group-item" id="balance_total_unpaid"
                                                            style="padding: 5px;"></li>
                                                        <li class="list-group-item" id="balance_total_final"
                                                            style="padding: 5px;"></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-2">
                                <table class="table table-bordered nowrap" style="width: 100%;" id="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre estudiante</th>
                                            <th>Fecha nacimiento</th>
                                            <th>Curso</th>
                                            <th>Periodo curso</th>
                                            <th>Fecha inicio</th>
                                            <th>Fecha termino</th>
                                            <th>Total a pagar</th>
                                            <th>Método de pago</th>
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

    @include('backend.sections.subscriptions.show')
@endsection

@section('scripts')
    <script>
        $(function() {
            var unpaidRoute =
                '{{ route('subscriptions.index', ['payed' => 'unpaid', 'year' => now()->year, 'month' => now()->format('m')]) }}';
            $('#balance_total_payed').html('<h5><span class="badge badge-pill badge-info">Total pagadas</span> $' +
                @json(chileanPeso($totalPayed)) + '</h5>');
            $('#balance_total_unpaid').html(
                '<h5><span class="badge badge-pill badge-danger">Total no pagadas</span> $' +
                @json(chileanPeso($totalUnpaid)) + ' <a class="btn btn-sm btn-danger float-sm-right" href="' +
                unpaidRoute + '">Ver listado</a></h5>');
            $('#balance_total_final').html('<h5><span class="badge badge-pill badge-success">Total final</span> $' +
                @json(chileanPeso($totalFinal)) + '</h5>');

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: route('subscriptions_payments.index'),
                    data: function(d) {
                        d.filter_class = $('#filter_class').val();
                        d.filter_year = $('#filter_year').val();
                        d.filter_month = $('#filter_month').val();
                    }
                },
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json"
                },
                columnDefs: [{
                        targets: 2,
                        render: function(data) {
                            return moment(data).format('DD-MM-YYYY');
                        }
                    },
                    {
                        targets: 5,
                        render: function(data) {
                            return moment(data).format('DD-MM-YYYY');
                        }
                    },
                    {
                        targets: 6,
                        render: function(data) {
                            return moment(data).format('DD-MM-YYYY');
                        }
                    }
                ],
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'student.full_name',
                        name: 'student.full_name'
                    },
                    {
                        data: 'student.birth_date',
                        name: 'student.birth_date'
                    },
                    {
                        data: 'course.name',
                        name: 'course.name'
                    },
                    {
                        data: 'course.period',
                        name: 'course.period'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'payment_media',
                        name: 'payment_media'
                    },
                    {
                        data: 'payed',
                        name: 'payed'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ],
                order: [
                    [7, 'desc']
                ]
            });

            $('#filter_class, #filter_month, #filter_year').change(function() {
                var oTable = $('#table').dataTable();
                oTable.fnDraw(false);

                let getBalanceUrl = route('subscriptions_payments.get_balance', [
                    $('#filter_month').val(),
                    $('#filter_year').val(),
                    $('#filter_class').val()
                ]);
                let balanceTotalUnpaidHref = route('subscriptions.index', {
                    _query: {
                        'payed': 'unpaid',
                        'year': $('#filter_year').val(),
                        'month': $('#filter_month').val(),
                        'class': $('#filter_class').val()
                    }
                });

                $.get(getBalanceUrl, function(data) {
                    $('#balance_title').text(data['balance_title']);

                    $('#balance_total_payed').html(
                        `<h5><span class="badge badge-pill badge-info">Total pagadas</span> ${data['balance_total_payed']}</h5>`
                    );
                    $('#balance_total_unpaid').html(
                        `<h5><span class="badge badge-pill badge-danger">Total no pagadas</span> ${data['balance_total_unpaid']} <a class="btn btn-sm btn-danger float-sm-right" href="${balanceTotalUnpaidHref}">Ver listado</a></h5>`
                    );
                    $('#balance_total_final').html(
                        `<h5><span class="badge badge-pill badge-success">Total final</span> ${data['balance_total_final']}</h5>`
                    );
                });
            });

            $('#table tbody').on('click', '.btn-detail', function() {
                let id = $(this).data('id');
                let url = route('subscriptions.show', id);

                $.get(url, function(data) {
                    $('#detail_school').html('<strong>Escuela: </strong>' + data['school']);
                    $('#detail_course').html('<strong>Curso: </strong>' + data['course']);
                    $('#detail_student').html('<strong>Estudiante: </strong>' + data['student']);
                    $('#detail_start_date').html('<strong>Fecha Inicio: </strong>' + data[
                        'start_date']);
                    $('#detail_end_date').html('<strong>Fecha Termino: </strong>' + data[
                        'end_date']);
                    $('#detail_total').html('<strong>Total a Pagar: </strong>' + data['total']);
                    $('#detail_payment_media').html('<strong>Metodo Pago: </strong>' + data[
                        'payment_media']);
                    $('#detail_payed').html('<strong>Pagado: </strong>' + data['payed']);

                    if (data['proxy']) {
                        $('#proxy_full_name').removeClass('hidden');
                        $('#proxy_phone').removeClass('hidden');
                        $('#proxy_full_name').html('<strong>Apoderado: </strong>' + data['proxy'][
                            'full_name'
                        ]);
                        $('#proxy_phone').html('<strong>Fono: </strong>' + data['proxy']['phone']);
                    }
                });

                $('#detailModal').modal('show');
            });
        });
    </script>
@endsection
