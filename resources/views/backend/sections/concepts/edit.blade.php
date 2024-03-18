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
                            <h3 class="card-title">Concepto</h3>
                        </div>

                        <form action="{{ route('concepts.update', $concept) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input type="text" name="name" id="name" value="{{ old('name', $concept->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Ingrese nombre">
                                            @error('name')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="type">Tipo</label>
                                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                                                <option value="">Seleccione</option>
                                                <option value="Ingreso" {{ $concept->type == 'Ingreso' ? 'selected' : '' }}>Ingreso</option>
                                                <option value="Gasto" {{ $concept->type == 'Gasto' ? 'selected' : '' }}>Gasto</option>
                                            </select>
                                            @error('type')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('concepts.index') }}">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
