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
                            <h3 class="card-title">Curso</h3>
                        </div>

                        <form action="{{ route('courses.store') }}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="school_id">Escuela</label>
                                            <select name="school_id" id="school_id" class="form-control @error('school_id') is-invalid @enderror">
                                                <option value="" {{ old('school_id') ? '' : 'selected' }}>Seleccione</option>
                                                @foreach ($schools as $school)
                                                    <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                                        {{ $school->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('school_id')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Ingrese nombre del curso">
                                            @error('name')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="description">Descripcion</label>
                                            <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Ingrese descripcion del curso">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="period">Periodo</label>
                                            <select name="period" id="period" class="form-control @error('period') is-invalid @enderror">
                                                <option value="" {{ old('period') ? '' : 'selected' }}>Seleccione</option>
                                                <option value="Dia unico" {{ old('period') == 'Dia unico' ? 'selected' : '' }}>Dia unico</option>
                                                <option value="Semanal" {{ old('period') == 'Semanal' ? 'selected' : '' }}>Semanal</option>
                                                <option value="Mensual" {{ old('period') == 'Mensual' ? 'selected' : '' }}>Mensual</option>
                                                <option value="Semestral" {{ old('period') == 'Semestral' ? 'selected' : '' }}>Semestral</option>
                                                <option value="Anual" {{ old('period') == 'Anual' ? 'selected' : '' }}>Anual</option>
                                            </select>
                                            @error('period')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="price">Precio</label>
                                            <input type="text" name="price" id="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" placeholder="Ingrese precio del curso" onkeypress="return checkNumeric();" onkeyup="formatPrice(this);">
                                            @error('price')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('courses.index') }}">Volver</a>
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
        function formatPrice(ctrl) {
            if (event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40) {
                return;
            }

            var num = ctrl.value.replace(/\./g, '');
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/, '');
            ctrl.value = num;
        }

        function checkNumeric() {
            return event.keyCode >= 48 && event.keyCode <= 57;
        }

        $(function () {
            $('#school_id').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endsection
