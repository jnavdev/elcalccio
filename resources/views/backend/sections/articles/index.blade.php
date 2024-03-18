@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Noticias</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('articles.create') }}"><i class="fa fa-plus"></i>
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
                                            <th>Imagen</th>
                                            <th>Titulo</th>
                                            <th>Contenido</th>
                                            <th>Fecha</th>
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

    @include('backend.sections.articles.show')
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: route('articles.index')
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
                        data: 'image',
                        name: 'image',
                        orderable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'content',
                        name: 'content'
                    },
                    {
                        data: 'date',
                        name: 'date'
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
                let url = route('articles.show', id);

                $.get(url, function(data) {
                    $('#detail_image').html('<img class="img-fluid" src="' + data['image'] +
                        '" alt="' + data['title'] + '">');
                    $('#detail_title').html('<strong>Titulo: </strong>' + data['title']);
                    $('#detail_content').html('<strong>Contenido: </strong>' + data['content']);
                    $('#detail_date').html('<strong>Fecha: </strong>' + data['date']);
                });

                $('#detailModal').modal('show');
            });

            $('#table tbody').on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                let url = route('articles.destroy', id);
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
