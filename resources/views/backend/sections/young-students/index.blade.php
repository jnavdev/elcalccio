@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Escuela de Fútbol</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('young_students.create') }}"><i
                                class="fa fa-plus"></i> Nuevo registro</a>
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
                                    <form action="{{ route('young_students.date_of_birth_pdf') }}" method="POST">
                                        @csrf

                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="filter_subscription" id="filter_subscription_all"
                                                        value="all" checked>
                                                    <label class="form-check-label" for="filter_subscription_all">
                                                        Mostrar Todos
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="filter_subscription" id="filter_subscription_none"
                                                        value="none">
                                                    <label class="form-check-label" for="filter_subscription_none">
                                                        Mostrar sin suscripciones
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="filter_course_id">Curso</label>
                                                    <select name="filter_course_id" id="filter_course_id"
                                                        class="form-control">
                                                        <option value="">Todos</option>
                                                        @foreach ($courses as $course)
                                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="filter_start_year">Año Nacimiento (Desde)</label>
                                                    <select name="filter_start_year" id="filter_start_year"
                                                        class="form-control">
                                                        @foreach ($years as $year)
                                                            @if ($loop->first)
                                                                <option selected value="{{ $year }}">
                                                                    {{ $year }}</option>
                                                            @else
                                                                <option value="{{ $year }}">{{ $year }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="filter_end_year">Año Nacimiento (Hasta)</label>
                                                    <select name="filter_end_year" id="filter_end_year"
                                                        class="form-control">
                                                        @foreach ($years as $year)
                                                            @if ($loop->last)
                                                                <option selected value="{{ $year }}">
                                                                    {{ $year }}</option>
                                                            @else
                                                                <option value="{{ $year }}">{{ $year }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <button class="btn btn-sm btn-danger btn-block" type="submit"
                                                    style="margin-top: 35px;"><i class="fa fa-file-pdf-o"></i> Exportar
                                                    PDF</button>
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
                                            <th>Foto</th>
                                            <th>Nombre completo</th>
                                            <th>RUT</th>
                                            <th>Ciudad</th>
                                            <th>Fecha nacimiento</th>
                                            <th>Fono</th>
                                            <th>Sexo</th>
                                            <th>Apoderado</th>
                                            <th>Suscripcion</th>
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

    @include('backend.sections.young-students.show')
    @include('backend.sections.young-students.proxy')
@endsection

@section('scripts')
    <script>
        function cleanAndHideErrors() {
            $('#proxyModal').find('.ajax-error').html('');
            $('#proxyModal').find('.ajax-error').css('display', 'none');
        }

        function showFormErrors(res) {
            $.each(res.responseJSON.errors, function(key, value) {
                $('#error_' + key).html(value);
                $('#error_' + key).css('display', 'block');
            });
        }

        $(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: route('young_students.index'),
                    data: function(d) {
                        d.filter_subscription = $('input:radio[name="filter_subscription"]:checked')
                            .val();
                        d.filter_start_year = $('#filter_start_year').val();
                        d.filter_end_year = $('#filter_end_year').val();
                        d.filter_course_id = $('#filter_course_id').val();
                    }
                },
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json"
                },
                columnDefs: [{
                    render: function(data) {
                        return moment(data).format('DD-MM-YYYY');
                    },
                    targets: 5
                }],
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'profile_picture',
                        name: 'profile_picture',
                        orderable: false
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'rut',
                        name: 'rut'
                    },
                    {
                        data: 'commune.name',
                        name: 'commune.name'
                    },
                    {
                        data: 'birth_date',
                        name: 'birth_date'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'sex',
                        name: 'sex'
                    },
                    {
                        data: 'proxyButton',
                        name: 'proxyButton',
                        orderable: false
                    },
                    {
                        data: 'subscriptionButton',
                        name: 'subscriptionButton',
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

            $('input:radio[name="filter_subscription"]').change(function() {
                var oTable = $('#table').dataTable();
                oTable.fnDraw(false);
            });

            $('#filter_course_id').change(function () {
                var oTable = $('#table').dataTable();
                oTable.fnDraw(false);
            });

            $('#filter_start_year, #filter_end_year').change(function() {
                var oTable = $('#table').dataTable();
                oTable.fnDraw(false);
            });

            $('#proxy_rut').on('change', function(e) {
                $(this).val(format(e.target.value));
            });

            $('#table tbody').on('click', '.btn-detail', function() {
                let id = $(this).data('id');
                let url = route('young_students.show', id);

                $.get(url, function(data) {
                    var student = data['student'];
                    var proxy = data['proxy'];

                    $('#detail_profile_picture').html(
                        '<img style="width: 200px; height: 250px;" class="rounded mx-auto d-block" src="' +
                        student['profile_picture'] + '" alt="' + student['full_name'] + '">');
                    $('#detail_full_name').html('<strong>Nombre Completo: </strong>' + student[
                        'full_name']);
                    $('#detail_rut').html('<strong>RUT: </strong>' + student['rut']);
                    $('#detail_birth_date').html('<strong>Fecha Nacimiento: </strong>' + student[
                        'birth_date']);
                    $('#detail_nationality').html('<strong>Nacionalidad: </strong>' + student[
                        'nationality']);
                    $('#detail_sex').html('<strong>Sexo: </strong>' + student['sex']);
                    $('#detail_commune').html('<strong>Ciudad: </strong>' + student['commune']);
                    $('#detail_address').html('<strong>Direccion: </strong>' + student['address']);
                    $('#detail_email').html('<strong>Email: </strong>' + student['email']);
                    $('#detail_phone').html('<strong>Fono: </strong>' + student['phone']);
                    $('#detail_created_at').html('<strong>Registrado el: </strong>' + student[
                        'created_at']);

                    $('#detail_disability').html('<strong>Discapacidad: </strong>' + student[
                        'disability']);
                    $('#detail_conadis').html('<strong>Registro CONADIS Numero Carnet: </strong>' +
                        student['conadis']);
                    $('#detail_diseases').html('<strong>Enfermedades: </strong>' + student[
                        'diseases']);
                    $('#detail_medicines').html('<strong>Medicamentos: </strong>' + student[
                        'medicines']);
                    $('#detail_allergies').html('<strong>Alergias: </strong>' + student[
                        'allergies']);
                    $('#detail_blood_type').html('<strong>Tipo Sangre: </strong>' + student[
                        'blood_type']);

                    $('#detail_shoe_number').html('<strong>Numero Calzado: </strong>' + student[
                        'shoe_number']);
                    $('#detail_shirt_size').html('<strong>Talla Camiseta: </strong>' + student[
                        'shirt_size']);
                    $('#detail_pants_size').html('<strong>Talla Pantalon: </strong>' + student[
                        'pants_size']);
                    $('#detail_height').html('<strong>Estatura: </strong>' + student['height']);
                    $('#detail_weight').html('<strong>Peso: </strong>' + student['weight']);

                    $('#detail_proxy_full_name').html('<strong>Nombre Completo: </strong>' + proxy[
                        'full_name']);
                    $('#detail_proxy_rut').html('<strong>RUT: </strong>' + proxy['rut']);
                    $('#detail_proxy_email').html('<strong>Email: </strong>' + proxy['email']);
                    $('#detail_proxy_relationship').html('<strong>Parentesco: </strong>' + proxy[
                        'relationship']);
                    $('#detail_proxy_phone').html('<strong>Fono: </strong>' + proxy['phone']);
                    $('#detail_proxy_commune').html('<strong>Ciudad: </strong>' + proxy['commune']);
                    $('#detail_proxy_address').html('<strong>Direccion: </strong>' + proxy[
                        'address']);
                });

                $('#detailModal').modal('show');
            });

            $('#table tbody').on('click', '.btn-proxy', function() {
                let id = $(this).data('id');
                let url = route('young_students.edit.proxy', id);

                $.get(url, function(data) {
                    $('#proxy_id').val(data['id']);
                    $('#proxy_full_name').val(data['full_name']);
                    $('#proxy_rut').val(data['rut']);
                    $('#proxy_email').val(data['email']);
                    $('#proxy_relationship').val(data['relationship']);
                    $('#proxy_phone').val(data['phone']);
                    $('#proxy_commune_id').val(data['commune_id']);
                    $('#proxy_address').val(data['address']);
                });

                $('#proxyModal').modal('show');
            });

            $('#buttonUpdateProxy').click(function() {
                cleanAndHideErrors();

                var formData = new FormData();
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                formData.append('proxy_id', $('#proxy_id').val());
                formData.append('full_name', $('#proxy_full_name').val());
                formData.append('rut', $('#proxy_rut').val());
                formData.append('email', $('#proxy_email').val());
                formData.append('relationship', $('#proxy_relationship').val());
                formData.append('phone', $('#proxy_phone').val());
                formData.append('commune_id', $('#proxy_commune_id').val());
                formData.append('address', $('#proxy_address').val());

                $.ajax({
                    url: route('young_students.update.proxy', $('#proxy_id').val()),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        cleanAndHideErrors();
                        $('#proxyModal').modal('hide');
                        var oTable = $('#table').dataTable();
                        oTable.fnDraw(false);

                        flasher.success(res.message);
                    },
                    error: function(res) {
                        showFormErrors(res);
                    }
                });
            });

            $('#table tbody').on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                let url = route('young_students.destroy', id);
                $('#delete-form').attr('action', url);

                Swal.fire({
                    title: '¿Realizar esta accion?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form').submit();
                    }
                });
            });
        });
    </script>
@endsection
