@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Nuevo registro</h1>
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
                            <h3 class="card-title">Album fotos</h3>
                        </div>

                        <form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="title">Titulo</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                id="title" name="title" placeholder="Ingrese titulo"
                                                value="{{ old('title') }}">
                                            @error('title')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="description">Descripcion</label>
                                            <textarea name="description" id="description" cols="30" rows="3"
                                                class="form-control @error('description') is-invalid @enderror" placeholder="Ingrese descripcion">{{ old('description') }}</textarea>
                                            @error('description')
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
                                                placeholder="Ingrese fecha" value="{{ old('date') }}">
                                            @error('date')
                                                <span
                                                    style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <strong>Dejar activo?</strong>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" id="is_active_yes" value="1" checked>
                                            <label class="form-check-label" for="is_active_yes">
                                                Si
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" id="is_active_no" value="0">
                                            <label class="form-check-label" for="is_active_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="photos">Fotos</label>
                                            <input type="file" class="form-control" id="photos" name="photos[]" multiple>
                                            @error('photos')
                                                <span
                                                    style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('albums.index') }}">Volver</a>
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
        $(function() {
            $('#photos').fileinput({
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
