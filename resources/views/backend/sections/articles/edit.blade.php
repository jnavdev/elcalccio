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
                            <h3 class="card-title">Noticia</h3>
                        </div>

                        <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="image">Imagen (Opcional)</label>
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
                                            <label for="title">Titulo</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                id="title" name="title" placeholder="Ingrese titulo"
                                                value="{{ old('title', $article->title) }}">
                                            @error('title')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="content">Contenido</label>
                                            <textarea name="content" id="content" cols="30" rows="20"
                                                class="form-control @error('content') is-invalid @enderror">{{ old('content', $article->content) }}</textarea>
                                            @error('content')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="date">Fecha</label>
                                            <input type="text" name="date" id="date" autocomplete="off"
                                                class="form-control @error('date') is-invalid @enderror"
                                                placeholder="Ingrese fecha" value="{{ old('date', $article->date->format('d-m-Y')) }}">
                                            @error('date')
                                                <span
                                                    style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('articles.index') }}">Volver</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 300px !important;
        }
    </style>
@endsection

@section('scripts')
    <script>
        ClassicEditor.create(document.querySelector('#content'));

        $(function() {
            $('#image').fileinput({
                showRemove: false,
                showUpload: false,
                showPreview: false,
                showCancel: false,
                browseLabel: 'Buscar archivo'
            });

            $('#date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                iconsLibrary: 'fontawesome'
            });
        });
    </script>
@endsection
