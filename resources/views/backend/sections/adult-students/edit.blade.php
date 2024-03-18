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
                            <h3 class="card-title">Estudiante Academia Calccio FC</h3>
                        </div>

                        <form action="{{ route('adult_students.update', $student) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="card-body">
                                <h4><span class="badge badge-primary">Datos personales</span></h4>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="profile_picture">Foto perfil (Opcional)</label>
                                            <input type="file" class="form-control" id="profile_picture"
                                                name="profile_picture">
                                            @error('profile_picture')
                                                <span
                                                    style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="full_name">Nombre completo</label>
                                            <input type="text"
                                                class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                                                name="full_name" placeholder="Ingrese nombre completo"
                                                value="{{ old('full_name', $student->full_name) }}">
                                            @error('full_name')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="rut">RUT</label>
                                            <input type="text" class="form-control @error('rut') is-invalid @enderror"
                                                id="rut" name="rut" placeholder="Ingrese RUT"
                                                value="{{ old('rut', $student->rut) }}">
                                            @error('rut')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="birth_date">Fecha nacimiento</label>
                                            <input type="text" name="birth_date" id="birth_date" autocomplete="off"
                                                class="form-control @error('birth_date') is-invalid @enderror"
                                                placeholder="Ingrese fecha nacimiento" value="{{ old('birth_date', $student->birth_date->format('d-m-Y')) }}">
                                            @error('birth_date')
                                                <span
                                                    style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="nationality">Nacionalidad</label>
                                            <input type="text" name="nationality" id="nationality" class="form-control @error('nationality') is-invalid @enderror"
                                                placeholder="Ingrese nacionalidad" value="{{ old('nationality', $student->nationality) }}">
                                            @error('nationality')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="sex">Sexo</label>
                                            <select name="sex" id="sex" class="form-control @error('sex') is-invalid @enderror">
                                                <option value="">Seleccione</option>
                                                <option value="M" {{ $student->sex == 'M' ? 'selected' : '' }}>Masculino</option>
                                                <option value="F" {{ $student->sex == 'F' ? 'selected' : '' }}>Femenino</option>
                                            </select>
                                            @error('sex')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="commune_id">Ciudad</label>
                                            <select name="commune_id" id="commune_id" class="form-control @error('commune_id') is-invalid @enderror">
                                                <option value="">Seleccione</option>
                                                @foreach ($communes as $commune)
                                                    <option value="{{ $commune->id }}" {{ $commune->id == $student->commune_id ? 'selected' : '' }}>
                                                        {{ $commune->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('commune_id')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="address">Direccion</label>
                                            <input type="text"
                                                class="form-control @error('full_name') is-invalid @enderror" id="address"
                                                name="address" placeholder="Ingrese direccion"
                                                value="{{ old('address', $student->address) }}">
                                            @error('address')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" placeholder="Ingrese email"
                                                value="{{ old('email', $student->email) }}">
                                            @error('email')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="phone">Fono</label>
                                            <input type="text"
                                                class="form-control @error('phone') is-invalid @enderror" id="phone"
                                                name="phone" placeholder="Ingrese fono"
                                                value="{{ old('phone', $student->phone) }}">
                                            @error('phone')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <h4><span class="badge badge-primary">Datos de salud</span></h4>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="disability">Discapacidad</label>
                                            <input type="text"
                                                class="form-control @error('disability') is-invalid @enderror" id="disability"
                                                name="disability" placeholder="Ingrese discapacidad"
                                                value="{{ old('disability', $student->disability) }}">
                                            @error('disability')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="conadis">Registro CONADIS Numero Carnet</label>
                                            <input type="text"
                                                class="form-control @error('conadis') is-invalid @enderror" id="conadis"
                                                name="conadis" placeholder="Ingrese CONADIS"
                                                value="{{ old('conadis', $student->conadis) }}">
                                            @error('conadis')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="diseases">Enfermedades</label>
                                            <input type="text"
                                                class="form-control @error('diseases') is-invalid @enderror" id="diseases"
                                                name="diseases" placeholder="Ingrese enfermedades"
                                                value="{{ old('diseases', $student->diseases) }}">
                                            @error('diseases')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="medicines">Medicamentos</label>
                                            <input type="text"
                                                class="form-control @error('medicines') is-invalid @enderror" id="medicines"
                                                name="medicines" placeholder="Ingrese medicamentos"
                                                value="{{ old('medicines', $student->medicines) }}">
                                            @error('medicines')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="allergies">Alergias</label>
                                            <input type="text"
                                                class="form-control @error('allergies') is-invalid @enderror" id="allergies"
                                                name="allergies" placeholder="Ingrese alergias"
                                                value="{{ old('allergies', $student->allergies) }}">
                                            @error('allergies')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="blood_type">Tipo sangre</label>
                                            <select name="blood_type" id="blood_type" class="form-control @error('blood_type') is-invalid @enderror">
                                                <option value="">Seleccione</option>
                                                <option value="A positivo" {{ $student->blood_type == 'A positivo' ? 'selected' : '' }}>A positivo</option>
                                                <option value="A negativo" {{ $student->blood_type == 'A negativo' ? 'selected' : '' }}>A negativo</option>
                                                <option value="B positivo" {{ $student->blood_type == 'B positivo' ? 'selected' : '' }}>B positivo</option>
                                                <option value="B negativo" {{ $student->blood_type == 'B negativo' ? 'selected' : '' }}>B negativo</option>
                                                <option value="AB positivo" {{ $student->blood_type == 'AB positivo' ? 'selected' : '' }}>AB positivo</option>
                                                <option value="AB negativo" {{ $student->blood_type == 'AB negativo' ? 'selected' : '' }}>AB negativo</option>
                                                <option value="O positivo" {{ $student->blood_type == 'O positivo' ? 'selected' : '' }}>O positivo</option>
                                                <option value="O negativo" {{ $student->blood_type == 'O negativo' ? 'selected' : '' }}>O negativo</option>
                                            </select>
                                            @error('blood_type')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <h4><span class="badge badge-primary">Datos complementarios</span></h4>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="shirt_number">Numero Camiseta (Dorsal)</label>
                                            <input type="number"
                                                   class="form-control @error('shirt_number') is-invalid @enderror" id="shirt_number"
                                                   name="shirt_number" placeholder="Ingrese numero camiseta"
                                                   value="{{ old('shirt_number', $student->shirt_number) }}">
                                            @error('shirt_number')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="shoe_number">Numero Calzado</label>
                                            <input type="number"
                                                class="form-control @error('shoe_number') is-invalid @enderror" id="shoe_number"
                                                name="shoe_number" placeholder="Ingrese numero calzado"
                                                value="{{ old('shoe_number', $student->shoe_number) }}">
                                            @error('shoe_number')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="shirt_size">Talla Camiseta</label>
                                            <input type="text"
                                                class="form-control @error('shirt_size') is-invalid @enderror" id="shirt_size"
                                                name="shirt_size" placeholder="Ingrese talla camiseta"
                                                value="{{ old('shirt_size', $student->shirt_size) }}">
                                            @error('shirt_size')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="pants_size">Talla Pantalon</label>
                                            <input type="number"
                                                class="form-control @error('pants_size') is-invalid @enderror" id="pants_size"
                                                name="pants_size" placeholder="Ingrese talla pantalon"
                                                value="{{ old('pants_size', $student->pants_size) }}">
                                            @error('pants_size')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="height">Estatura (cm)</label>
                                            <input type="number"
                                                class="form-control @error('height') is-invalid @enderror" id="height"
                                                name="height" placeholder="Ingrese estatura en centimetros"
                                                value="{{ old('height', $student->height) }}">
                                            @error('height')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="weight">Peso (kg)</label>
                                            <input type="number"
                                                class="form-control @error('weight') is-invalid @enderror" id="weight"
                                                name="weight" placeholder="Ingrese peso en kilos"
                                                value="{{ old('weight', $student->weight) }}">
                                            @error('weight')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="authorization_file">Ficha autorizacion (Opcional)</label>
                                            <input type="file" class="form-control" id="authorization_file"
                                                name="authorization_file">
                                            @error('authorization_file')
                                                <span
                                                    style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('adult_students.index') }}">Volver</a>
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
            $('#rut').on('change', function(e) {
                $(this).val(format(e.target.value));
            });

            $('#commune_id').select2({
                theme: 'bootstrap4'
            });

            $('#birth_date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                iconsLibrary: 'fontawesome'
            });

            $('#profile_picture, #authorization_file').fileinput({
                showRemove: false,
                showUpload: false,
                showPreview: false,
                showCancel: false,
                browseLabel: 'Buscar archivo'
            });
        });
    </script>
@endsection
