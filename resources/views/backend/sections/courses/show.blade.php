@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detalle</h1>
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
                            <h3 class="card-title">Curso</h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="w-25">Escuela</th>
                                        <td>{{ $course->school->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">Nombre curso</th>
                                        <td>{{ $course->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">Descripcion curso</th>
                                        <td>{{ $course->description }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">Periodo</th>
                                        <td>{{ $course->period }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">Precio</th>
                                        <td>{{ chileanPeso($course->price) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">Estado</th>
                                        <td>
                                            @if ($course->is_active)
                                                <span class="badge badge-pill badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-pill badge-danger">Inactivo</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            <a class="btn btn-secondary" href="{{ route('courses.index') }}">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
