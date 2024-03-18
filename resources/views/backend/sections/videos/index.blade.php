@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Videos</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('videos.create') }}"><i class="fa fa-plus"></i>
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
                            <div class="table-responsive">
                                <table class="table table-bordered nowrap" style="width: 100%;" id="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Miniatura</th>
                                            <th>Orden</th>
                                            <th>Titulo</th>
                                            <th>Fecha</th>
                                            <th>Para escuela</th>
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

    @include('backend.sections.videos.show')
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: route('videos.index')
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
                        data: 'thumbnail',
                        name: 'thumbnail',
                        orderable: false
                    },
                    {
                        data: 'order',
                        name: 'order'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'for_school',
                        name: 'for_school'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });

            $('#table tbody').on('click', '.btn-detail', function() {
                let id = $(this).data('id');
                let url = route('videos.show', id);

                $.get(url, function(data) {
                    $('#detail_title').html('<strong>Titulo: </strong>' + data['title']);
                    $('#detail_date').html('<strong>Fecha: </strong>' + data['date']);
                    $('#detail_for_school').html('<strong>Para escuela: </strong>' + data[
                        'for_school']);
                    $('#detail_order').html('<strong>Orden: </strong>' + data['order']);
                    $('#div_iframe_video').html(data['iframe']);
                });

                $('#detailModal').modal('show');
            });

            $('#table tbody').on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                let url = route('videos.destroy', id);
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
