@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Asistencia</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Buscar</h3>
                                </div>

                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <select name="course_id" id="course_id"
                                                        class="form-control">
                                                        <option value="" selected>Seleccione Curso</option>
                                                        @foreach ($courses as $course)
                                                            <option value="{{ $course->id }}">{{ $course->name }} - {{ $course->school->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input type="text" name="date" id="date" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i>
                                                    Buscar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @if ($students->count())
                                <div class="table-responsive">
                                    <form action="{{ route('attendance.check_save') }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="attendance_date" id="attendance_date" value="">
                                        <input type="hidden" name="attendance_course_id" id="attendance_course_id" value="">

                                        <table class="table table-sm table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="w-50">Estudiante</th>
                                                    <th class="w-50">Asistencia</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($students as $student)
                                                    <tr>
                                                        <td>{{ $student->full_name }}</td>
                                                        <td>
                                                            <div class="form-group">
                                                                @if ($student->attendance)
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="present_{{ $student->id }}" name="attendance[{{ $student->id }}]" value="1" {{ ($student->attendance->state == 'Presente') ? 'checked' : '' }}>
                                                                        <label for="present_{{ $student->id }}" class="custom-control-label">Presente</label>
                                                                    </div>

                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="absence_{{ $student->id }}" name="attendance[{{ $student->id }}]" value="0" {{ ($student->attendance->state == 'Ausente') ? 'checked' : '' }}>
                                                                        <label for="absence_{{ $student->id }}" class="custom-control-label">Ausente</label>
                                                                    </div>
                                                                @else
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="present_{{ $student->id }}" name="attendance[{{ $student->id }}]" value="1">
                                                                        <label for="present_{{ $student->id }}" class="custom-control-label">Presente</label>
                                                                    </div>

                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="absence_{{ $student->id }}" name="attendance[{{ $student->id }}]" value="0">
                                                                        <label for="absence_{{ $student->id }}" class="custom-control-label">Ausente</label>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Guardar</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let params = (new URL(document.location)).searchParams;
        let paramCouseId = params.get('course_id');
        let paramDate = params.get('date');

        $(function() {
            $('#date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                iconsLibrary: 'fontawesome',
                value: (paramDate) ? paramDate : moment().format('DD-MM-YYYY')
            });

            $('#attendance_date').val(paramDate);
            $('#attendance_course_id').val(paramCouseId);
            $('#course_id').val(paramCouseId);
        });
    </script>
@endsection
