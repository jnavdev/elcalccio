@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Suscripciones</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('subscriptions.create') }}"><i class="fa fa-plus"></i>
                            Nuevo registro</a>
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
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="filter_state"
                                                        id="filter_state_all" value="all" checked>
                                                    <label class="form-check-label" for="filter_state_all">
                                                        Mostrar Todas
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="filter_state"
                                                        id="filter_state_unpaid" value="unpaid">
                                                    <label class="form-check-label" for="filter_state_unpaid">
                                                        Mostrar no pagadas
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="filter_state"
                                                        id="filter_state_payed" value="payed">
                                                    <label class="form-check-label" for="filter_state_payed">
                                                        Mostrar pagadas
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="filter_class"
                                                        id="filter_class_all" value="all" checked>
                                                    <label class="form-check-label" for="filter_class_all">
                                                        Mostrar Todos
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="filter_class"
                                                        id="filter_class_menor_edad" value="Menor Edad">
                                                    <label class="form-check-label" for="filter_class_menor_edad">
                                                        Mostrar Escuela de Fútbol
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="filter_class"
                                                        id="filter_class_mayor_edad" value="Mayor Edad">
                                                    <label class="form-check-label" for="filter_class_mayor_edad">
                                                        Mostrar Academia Calccio FC
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="filter_birth_date">Año nacimiento estudiante</label>
                                                    <select name="filter_birth_date" id="filter_birth_date"
                                                        class="form-control">
                                                        <option value="" selected>Todos</option>
                                                        @foreach ($birthDateYears as $year)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="filter_year">Año suscripcion</label>
                                                    <select name="filter_year" id="filter_year" class="form-control">
                                                        <option value="" selected>Todos</option>
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="filter_month">Mes suscripcion</label>
                                                    <select name="filter_month" id="filter_month" class="form-control">
                                                        <option value="" selected>Todos</option>
                                                        <option value="01">Enero</option>
                                                        <option value="02">Febrero</option>
                                                        <option value="03">Marzo</option>
                                                        <option value="04">Abril</option>
                                                        <option value="05">Mayo</option>
                                                        <option value="06">Junio</option>
                                                        <option value="07">Julio</option>
                                                        <option value="08">Agosto</option>
                                                        <option value="09">Septiembre</option>
                                                        <option value="10">Octubre</option>
                                                        <option value="11">Noviembre</option>
                                                        <option value="12">Diciembre</option>
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
                                            <th>Nombre estudiante</th>
                                            <th>Fecha nacimiento</th>
                                            <th>Curso</th>
                                            <th>Periodo curso</th>
                                            <th>Fecha inicio</th>
                                            <th>Fecha termino</th>
                                            <th>Total a pagar</th>
                                            <th>Método de pago</th>
                                            <th>Estado</th>
                                            <th>Pagar</th>
                                            <th>Acciones</th>
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

    @include('backend.sections.subscriptions.show')
    @include('backend.sections.subscriptions.pay')
@endsection

@section('scripts')
    <script>
        $(function() {
            let params = (new URL(document.location)).searchParams;
            let paramPayed = params.get('payed');
            let paramYear = params.get('year');
            let paramMonth = params.get('month');
            let paramClass = params.get('class');

            if (paramPayed, paramYear, paramMonth, paramClass) {
                $('input[name="filter_state"][value="' + paramPayed + '"]').prop('checked', true);
                $('input[name="filter_class"][value="' + paramClass + '"]').prop('checked', true);
                $('#filter_year').val(paramYear);
                $('#filter_month').val(paramMonth);
            }

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: route('subscriptions.index'),
                    data: function(d) {
                        d.filter_state = $('input:radio[name="filter_state"]:checked').val();
                        d.filter_class = $('input:radio[name="filter_class"]:checked').val();
                        d.filter_year = $('#filter_year').val();
                        d.filter_month = $('#filter_month').val();
                        d.filter_birth_date = $('#filter_birth_date').val();
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
                        data: 'payButton',
                        name: 'payButton',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ]
            });

            $('input:radio[name="filter_state"], input:radio[name="filter_class"]').change(function() {
                var oTable = $('#table').dataTable();
                oTable.fnDraw(false);
            });

            $('#filter_year, #filter_month, #filter_birth_date').change(function() {
                var oTable = $('#table').dataTable();
                oTable.fnDraw(false);
            });


            $('#table tbody').on('click', '.btn-detail', function() {
                let id = $(this).data('id');
                let url = route('subscriptions.show', id);

                $.get(url, function(data) {
                    if (data['proxy']) {
                        $('#div-proxy-data').css('display', 'block');
                        $('#div-student-data').attr('class', 'col-sm-6');
                        $('#proxy_full_name').html('<strong>Apoderado: </strong>' + data['proxy'][
                            'full_name'
                        ]);
                        $('#proxy_relationship').html('<strong>Parentesco: </strong>' + data[
                            'proxy']['relationship']);
                        $('#proxy_phone').html('<strong>Fono: </strong>' + data['proxy']['phone']);
                    } else {
                        $('#div-proxy-data').css('display', 'none');
                        $('#div-student-data').attr('class', 'col-sm-12');
                    }

                    $('#detail_student_full_name').html('<strong>Estudiante: </strong>' + data[
                        'student_full_name']);
                    $('#detail_student_birth_date').html('<strong>Fecha nacimiento: </strong>' +
                        data[
                            'student_birth_date']);
                    $('#detail_student_rut').html('<strong>RUT: </strong>' + data[
                        'student_rut']);

                    $('#detail_school').html('<strong>Escuela: </strong>' + data['school']);
                    $('#detail_course').html('<strong>Curso: </strong>' + data['course']);

                    $('#detail_start_date').html('<strong>Fecha Inicio: </strong>' + data[
                        'start_date']);
                    $('#detail_end_date').html('<strong>Fecha Termino: </strong>' + data[
                        'end_date']);
                    $('#detail_total').html('<strong>Total a Pagar: </strong>' + data['total']);
                    $('#detail_payment_media').html('<strong>Metodo Pago: </strong>' + data[
                        'payment_media']);
                    $('#detail_payed').html('<strong>Pagado: </strong>' + data['payed']);
                });

                $('#detailModal').modal('show');
            });

            $('#table tbody').on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                let url = route('subscriptions.destroy', id);
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

            $('#table').on('click', '.btn-pay', function() {
                let id = $(this).data('id');

                $('#subscription_id').val(id);
                $('input[name="next_subscription"][value="1"]').prop('checked', true);

                $('#payModal').modal('show');
            });

            $('#buttonPay').click(function() {
                var formData = new FormData();
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                formData.append('subscription_id', $('#subscription_id').val());
                formData.append('next_subscription', $('input[name="next_subscription"]:checked').val());

                $.ajax({
                    url: route('subscriptions.pay', $('#subscription_id').val()),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $('#payModal').modal('hide');
                        var oTable = $('#table').dataTable();
                        oTable.fnDraw(false);

                        flasher.success(res.message);
                    }
                });
            });
        });
    </script>
@endsection
