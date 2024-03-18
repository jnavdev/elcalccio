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
                            <h3 class="card-title">Video</h3>
                        </div>

                        <form action="{{ route('videos.update', $video) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="title">Titulo</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                id="title" name="title" placeholder="Ingrese titulo"
                                                value="{{ old('title', $video->title) }}">
                                            @error('title')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="url">Link YouTube</label>
                                            <input type="text" class="form-control @error('url') is-invalid @enderror"
                                                id="url" name="url" placeholder="Ingrese link"
                                                value="{{ old('url', $video->url) }}">
                                            @error('url')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="date">Fecha</label>
                                            <input type="text" name="date" id="date" autocomplete="off"
                                                class="form-control @error('date') is-invalid @enderror"
                                                placeholder="Ingrese fecha" value="{{ old('date', $video->date->format('d-m-Y')) }}">
                                            @error('date')
                                                <span
                                                    style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="is_active">Activo</label>
                                            <select name="is_active" id="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                                <option value="">Seleccione</option>
                                                <option value="1" {{ $video->is_active == '1' ? 'selected' : '' }}>Si</option>
                                                <option value="0" {{ $video->is_active == '0' ? 'selected' : '' }}>No</option>
                                            </select>
                                            @error('is_active')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="order">Orden</label>
                                            <input type="number" class="form-control @error('order') is-invalid @enderror"
                                                id="order" name="order" placeholder="Ingrese orden"
                                                value="{{ old('order', $video->order) }}">
                                            @error('order')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="for_school">Para escuela</label>
                                            <select name="for_school" id="for_school" class="form-control @error('for_school') is-invalid @enderror">
                                                <option value="">Seleccione</option>
                                                <option value="1" {{ $video->for_school == '1' ? 'selected' : '' }}>Si</option>
                                                <option value="0" {{ $video->for_school == '0' ? 'selected' : '' }}>No</option>
                                            </select>
                                            @error('for_school')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('videos.index') }}">Volver</a>
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
            $('#date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                iconsLibrary: 'fontawesome'
            });
        });
    </script>
@endsection
