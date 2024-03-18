@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Productos</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('products.create') }}"><i class="fa fa-plus"></i>
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
                                            <th>Título</th>
                                            <th>Categoría</th>
                                            <th>Precio Costo</th>
                                            <th>Precio Venta</th>
                                            <th>Stock</th>
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

    @include('backend.sections.products.show')
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: route('products.index')
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
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'product_category_name',
                        name: 'product_category_name'
                    },
                    {
                        data: 'cost_price',
                        name: 'cost_price'
                    },
                    {
                        data: 'sale_price',
                        name: 'sale_price'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
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
                let url = route('products.show', id);

                $.get(url, function(data) {
                    $('#detail_image').html('<img width="100" height="100" src="' + data['image'] +
                        '" alt="' + data['title'] + '">');
                    $('#detail_category').html('<strong>Categoría: </strong>' + data['category']);
                    $('#detail_title').html('<strong>Título: </strong>' + data['title']);
                    $('#detail_description').html('<strong>Descripción: </strong>' + data[
                        'description']);
                    $('#detail_stock').html('<strong>Stock: </strong>' + data['stock']);
                    $('#detail_cost_price').html('<strong>Precio costo: </strong>' + data[
                        'cost_price']);
                    $('#detail_sale_price').html('<strong>Precio venta: </strong>' + data[
                        'sale_price']);
                });

                $('#detailModal').modal('show');
            });

            $('#table tbody').on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                let url = route('products.destroy', id);
                $('#delete-form').attr('action', url);

                Swal.fire({
                    title: '¿Cambiar estado?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si, cambiar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form').submit();
                    }
                });
            });
        });
    </script>
@endsection
