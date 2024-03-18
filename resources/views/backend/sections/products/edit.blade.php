@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Actualizar registro</h1>
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
                            <h3 class="card-title">Producto</h3>
                        </div>

                        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="image">Imágen</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                            @error('image')
                                                <span
                                                    style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="product_category_id">Categoría</label>
                                            <select name="product_category_id" id="product_category_id"
                                                class="form-control @error('product_category_id') is-invalid @enderror">
                                                <option value="" {{ old('product_category_id') ? '' : 'selected' }}>
                                                    Seleccione</option>
                                                @foreach ($productCategories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $product->product_category_id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('product_category_id')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="title">Título</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                id="title" name="title" placeholder="Ingrese título"
                                                value="{{ old('title', $product->title) }}">
                                            @error('title')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="description">Descripción</label>
                                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                                placeholder="Ingrese descripción" rows="4">{{ old('description', $product->description) }}</textarea>
                                            @error('description')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="cost_price">Precio costo</label>
                                            <input type="text" name="cost_price" id="cost_price" value="{{ old('cost_price', chileanPeso($product->productInventory->cost_price)) }}" class="form-control @error('cost_price') is-invalid @enderror"
                                                onkeypress="return checkNumeric();" onkeyup="formatPrice(this);" placeholder="Ingrese precio costo">
                                            @error('cost_price')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="sale_price">Precio venta</label>
                                            <input type="text" name="sale_price" id="sale_price" value="{{ old('sale_price', chileanPeso($product->productInventory->sale_price)) }}" class="form-control @error('sale_price') is-invalid @enderror"
                                                onkeypress="return checkNumeric();" onkeyup="formatPrice(this);" placeholder="Ingrese precio venta">
                                            @error('sale_price')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="stock">Stock</label>
                                            <input type="number"
                                                class="form-control @error('stock') is-invalid @enderror" id="stock"
                                                name="stock" placeholder="Ingrese stock"
                                                value="{{ old('stock', $product->stock) }}">
                                            @error('stock')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('products.index') }}">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function checkNumeric() {
            return event.keyCode >= 48 && event.keyCode <= 57;
        }

        function formatPrice(ctrl) {
            if (event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40) {
                return;
            }

            var num = ctrl.value.replace(/\./g, '');
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/, '');
            ctrl.value = num;
        }

        $(function() {
            $('#image').fileinput({
                showRemove: false,
                showUpload: false,
                showPreview: false,
                showCancel: false,
                browseLabel: 'Buscar archivo'
            });

            $('#product_category_id').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endsection
