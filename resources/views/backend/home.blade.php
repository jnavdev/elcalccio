@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total clientes</span>
                            <span class="info-box-number">{{ $totalCustomers }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Horas reservadas hoy</span>
                            <span class="info-box-number">{{ $totalReservationHoursToday }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Estudiantes Escuela de Fútbol</span>
                            <span class="info-box-number">{{ $totalYoungStudents }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Estudiantes Academia Calccio FC</span>
                            <span class="info-box-number">{{ $totalAdultStudents }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">
                        <i class="fas fa-birthday-cake"></i>
                        Proximos cumpleaños estudiantes
                    </h3>

                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item">
                            <form class="form-inline" method="POST" action="{{ route('admin.generate_birthdate_pdf') }}">
                                @csrf
                                <select name="birthdate_month" id="birthdate_month" class="form-control">
                                    <option value="01" {{ now()->format('m') == '01' ? 'selected' : '' }}>Enero
                                    </option>
                                    <option value="02" {{ now()->format('m') == '02' ? 'selected' : '' }}>Febrero
                                    </option>
                                    <option value="03" {{ now()->format('m') == '03' ? 'selected' : '' }}>Marzo
                                    </option>
                                    <option value="04" {{ now()->format('m') == '04' ? 'selected' : '' }}>Abril
                                    </option>
                                    <option value="05" {{ now()->format('m') == '05' ? 'selected' : '' }}>Mayo
                                    </option>
                                    <option value="06" {{ now()->format('m') == '06' ? 'selected' : '' }}>Junio
                                    </option>
                                    <option value="07" {{ now()->format('m') == '07' ? 'selected' : '' }}>Julio
                                    </option>
                                    <option value="08" {{ now()->format('m') == '08' ? 'selected' : '' }}>Agosto
                                    </option>
                                    <option value="09" {{ now()->format('m') == '09' ? 'selected' : '' }}>Septiembre
                                    </option>
                                    <option value="10" {{ now()->format('m') == '10' ? 'selected' : '' }}>Octubre
                                    </option>
                                    <option value="11" {{ now()->format('m') == '11' ? 'selected' : '' }}>Noviembre
                                    </option>
                                    <option value="12" {{ now()->format('m') == '12' ? 'selected' : '' }}>Diciembre
                                    </option>
                                </select>
                                <button type="submit" class="btn btn-danger ml-2"><i class="fa fa-file-pdf"></i> Generar
                                    PDF</button>
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    @if ($birthdayStudentsToday->count())
                        <div class="row">
                            @foreach ($birthdayStudentsToday as $student)
                                <div class="col-md-2">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                            <div class="text-center">
                                                <img class="profile-user-img img-fluid img-circle"
                                                    style="width: 128px; height: 128px;"
                                                    src="{{ asset($student->profile_picture) }}"
                                                    alt="{{ $student->full_name }}">
                                            </div>
                                            <h3 class="profile-username text-center">{{ $student->full_name }}</h3>
                                            <p class="text-muted text-center">{{ $student->birth_date->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <h6>
                            <i class="fas fa-exclamation-triangle"></i> Ninguno
                        </h6>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
