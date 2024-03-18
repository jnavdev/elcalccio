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
                <div class="col-md-6">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Informacion general del album</h3>
                        </div>

                        <form action="{{ route('albums.update', $album) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="title">Titulo</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                id="title" name="title" placeholder="Ingrese titulo"
                                                value="{{ old('title', $album->title) }}">
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
                                                class="form-control @error('description') is-invalid @enderror" placeholder="Ingrese descripcion">{{ old('description', $album->description) }}</textarea>
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
                                                placeholder="Ingrese fecha" value="{{ old('date', $album->date->format('d-m-Y')) }}">
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
                                            <input class="form-check-input" type="radio" name="is_active" id="is_active_yes" value="1" {{ ($album->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active_yes">
                                                Si
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" id="is_active_no" value="0" {{ (! $album->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Agregar mas fotos</h3>
                        </div>

                        <form action="{{ route('albums.add_photos', $album->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
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
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Fotos</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @foreach ($album->photos as $photo)
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <img src="{{ asset($photo->name) }}" class="card-img-top" alt="{{ $album->title }}" style="height: 200px;">
                                            <div class="card-body">
                                                <form action="{{ route('albums.delete_photo', $photo->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf

                                                    <button type="submit" class="btn btn-sm btn-block btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
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
