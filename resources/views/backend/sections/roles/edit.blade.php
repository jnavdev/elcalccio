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
                            <h3 class="card-title">Rol</h3>
                        </div>

                        <form action="{{ route('roles.update', $role) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" placeholder="Ingrese nombre"
                                                value="{{ old('name', $role->name) }}">
                                            @error('name')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <strong>Permisos</strong>

                                        <table class="table table-bordered mt-2" id="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 2%;"></th>
                                                    <th>Nombre</th>
                                                    <th>Ruta</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($permissions as $permission)
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input
                                                                    class="form-check-input"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    {{ $role->permissions->contains($permission) ? 'checked' : '' }}
                                                                >
                                                            </div>
                                                        </td>
                                                        <td>{{ $permission->label }}</td>
                                                        <td>{{ $permission->route_name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('roles.index') }}">Volver</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
