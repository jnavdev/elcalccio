@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cuadrar caja</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('money_closures.create') }}"><i
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
                            <div class="table-responsive">
                                <table class="table table-bordered nowrap" style="width: 100%;" id="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Cancha</th>
                                            <th>Responsable</th>
                                            <th>Efectivo recaudado</th>
                                            <th>Efectivo real</th>
                                            <th>Trans. recaudado</th>
                                            <th>Trans. real</th>
                                            <th>Débito recaudado</th>
                                            <th>Débito real</th>
                                            <th>Crédito recaudado</th>
                                            <th>Crédito real</th>
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

    @include('backend.sections.money-closures.show')
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: route('money_closures.index')
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
                        data: 'date',
                        name: 'date',
                        render: function (data, type, row, meta) {
                            return moment(data).format('DD-MM-YYYY');
                        }
                    },
                    {
                        data: 'stadium.name',
                        name: 'stadium.name'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'cash_collected_total',
                        name: 'cash_collected_total',
                        className: 'dt-center'
                    },
                    {
                        data: 'cash_real_total',
                        name: 'cash_real_total',
                        className: 'dt-center'
                    },
                    {
                        data: 'transfer_collected_total',
                        name: 'transfer_collected_total',
                        className: 'dt-center'
                    },
                    {
                        data: 'transfer_real_total',
                        name: 'transfer_real_total',
                        className: 'dt-center'
                    },
                    {
                        data: 'debt_collected_total',
                        name: 'debt_collected_total',
                        className: 'dt-center'
                    },
                    {
                        data: 'debt_real_total',
                        name: 'debt_real_total',
                        className: 'dt-center'
                    },
                    {
                        data: 'credit_collected_total',
                        name: 'credit_collected_total',
                        className: 'dt-center'
                    },
                    {
                        data: 'credit_real_total',
                        name: 'credit_real_total',
                        className: 'dt-center'
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

            $('#table tbody').on('click', '.btn-detail', function() {
                let id = $(this).data('id');
                let url = route('money_closures.show', id);

                $.get(url, function(data) {
                    $('#detail_user').html('<strong>Responsable: </strong>' + data['user']);
                    $('#detail_date').html('<strong>Fecha: </strong>' + data['date']);
                    $('#detail_stadium').html('<strong>Lugar: </strong>' + data['stadium']);
                    $('#table_cash').html('<td>' + data["cash_collected_total"] + '</td><td>' +
                        data["cash_real_total"] + '</td><td>' + data["cash_closure"] + '</td>');
                    $('#table_transfer').html('<td>' + data["transfer_collected_total"] +
                        '</td><td>' + data["transfer_real_total"] + '</td><td>' + data[
                            "transfer_closure"] + '</td>');
                    $('#table_debt').html('<td>' + data["debt_collected_total"] + '</td><td>' +
                        data["debt_real_total"] + '</td><td>' + data["debt_closure"] + '</td>');
                    $('#table_credit').html('<td>' + data["credit_collected_total"] + '</td><td>' +
                        data["credit_real_total"] + '</td><td>' + data["credit_closure"] +
                        '</td>');
                });

                $('#detailModal').modal('show');
            });

            $('#table tbody').on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                let url = route('money_closures.destroy', id);
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
        });
    </script>
@endsection
