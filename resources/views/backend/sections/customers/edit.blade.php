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
                            <h3 class="card-title">Cliente</h3>
                        </div>

                        <form action="{{ route('customers.update', $user) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                                name="name" placeholder="Ingrese el nombre" value="{{ old('name', $user->name) }}">
                                            @error('name')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" placeholder="Ingrese el email" value="{{ old('email', $user->email) }}">
                                            @error('email')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="rut">RUT</label>
                                            <input type="text" class="form-control @error('rut') is-invalid @enderror" id="rut"
                                                name="rut" placeholder="Ingrese el RUT" value="{{ old('rut', $user->rut) }}">
                                            @error('rut')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="phone">Telefono</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                                name="phone" placeholder="Ingrese el telefono" value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Es socio?</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="partner_no"
                                            name="partner" value="0" {{ (old('partner') == '0' || $user->partner == 0) ? 'checked' : '' }}>
                                        <label for="partner_no" class="custom-control-label">No</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio"
                                            id="partner_yes" name="partner"
                                            value="1" {{ (old('partner') == '1' || $user->partner == 1) ? 'checked' : '' }}>
                                        <label for="partner_yes" class="custom-control-label">Si</label>
                                    </div>
                                    @error('partner')
                                        <span
                                            style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                                        name="password" placeholder="Ingrese la contraseña">
                                    @error('password')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('customers.index') }}">Volver</a>
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
        });
    </script>
@endsection
