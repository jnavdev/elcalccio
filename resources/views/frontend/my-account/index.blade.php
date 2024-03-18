@extends('frontend.layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/gijgo@1.9.13/css/gijgo.min.css">
@endsection

@section('content')
    <!--Banner Start-->
    <section class="main-inner-banner jarallax" data-jarallax data-speed="0.2" data-imgPosition="20% 0%"
        style="background-image: url({{ asset('assets/frontend/images/fondo-calendario-reservas.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-in-title">
                        <h1 class="h1-title">Reserva tu hora</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Banner End-->

    <!--Class Detail Start-->
    <section class="main-class-detail" style="padding-top: 50px;">
        <div class="container">
            <div class="row">
                <!--Sidebar Start-->
                <div class="col-lg-3">
                    @include('frontend.my-account.partials.menu')
                </div>
                <!--Sidebar End-->

                <!--Class Detail Info Start-->
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <h5>Mis datos</h5>

                            <form action="{{ route('frontend.my_account.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="rut" class="form-label">RUT</label>
                                    <input type="text" class="form-control @error('rut') is-invalid @enderror"
                                        id="rut" name="rut" value="{{ old('rut', $user->rut) }}">
                                    @error('rut')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-warning">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!--Class Detail Info End-->
            </div>
        </div>
    </section>
    <!--Class Detail End-->
@endsection

@section('js')
    <script>
        $(function() {
            $('#rut').Rut();
        });
    </script>
@endsection
