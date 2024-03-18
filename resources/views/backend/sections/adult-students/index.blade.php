@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Academia Calccio FC</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('adult_students.create') }}"><i
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
                                    <form>
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
                                            <th>Direccion</th>
                                            <th>Fono</th>
                                            <th>Sexo</th>
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

    @include('backend.sections.adult-students.show')
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: route('adult_students.index'),
                    data: function(d) {
                        d.filter_subscription = $('input:radio[name="filter_subscription"]:checked')
                            .val();
                    }
                },
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json"
                },
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
                        data: 'address',
                        name: 'address'
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

            $('#table tbody').on('click', '.btn-detail', function() {
                let id = $(this).data('id');
                let url = route('adult_students.show', id);

                $.get(url, function(data) {
                    var student = data['student'];

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
                });

                $('#detailModal').modal('show');
            });

            $('#table tbody').on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                let url = route('adult_students.destroy', id);
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
