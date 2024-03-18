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
                            <h3 class="card-title">Suscripcion</h3>
                        </div>

                        <form action="{{ route('subscriptions.store') }}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="student_id">Estudiante</label>
                                            <select name="student_id" id="student_id" class="form-control @error('student_id') is-invalid @enderror">
                                                <option value="" {{ old('student_id') ? '' : 'selected' }}>Seleccione</option>
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                                        {{ $student->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('student_id')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="course_id">Curso</label>
                                            <select name="course_id" id="course_id" class="form-control @error('course_id') is-invalid @enderror">
                                                <option value="" {{ old('course_id') ? '' : 'selected' }}>Seleccione</option>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                                        {{ $course->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('course_id')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="payment_media">Método de Pago</label>
                                            <select name="payment_media" id="payment_media" class="form-control @error('payment_media') is-invalid @enderror">
                                                <option value="" {{ old('payment_media') ? '' : 'selected' }}>Seleccione</option>
                                                <option value="Efectivo" {{ old('payment_media') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                                                <option value="Transferencia" {{ old('payment_media') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                                                <option value="Débito" {{ old('payment_media') == 'Débito' ? 'selected' : '' }}>Débito</option>
                                                <option value="Crédito" {{ old('payment_media') == 'Crédito' ? 'selected' : '' }}>Crédito</option>
                                            </select>
                                            @error('payment_media')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="total">Total a pagar</label>
                                            <input type="text" name="total" id="total" value="{{ old('total') }}" class="form-control @error('total') is-invalid @enderror"
                                                onkeypress="return checkNumeric();" onkeyup="formatPrice(this);" placeholder="Ingrese total" autocomplete="off">
                                            @error('total')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="period">Periodo</label>
                                        <input name="period" id="period" class="form-control" disabled value="">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="start_date">Fecha inicio</label>
                                        <input name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" autocomplete="off" placeholder="Ingrese fecha inicio">
                                        @error('start_date')
                                            <span
                                                style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="end_date">Fecha termino</label>
                                        <input name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" autocomplete="off" placeholder="Ingrese fecha termino">
                                        @error('end_date')
                                            <span
                                                style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 mt-3">
                                        <strong>Marcar como pagada?</strong>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payed" id="payed_yes" value="1" checked>
                                            <label class="form-check-label" for="payed_yes">
                                                Si
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payed" id="payed_no" value="0">
                                            <label class="form-check-label" for="payed_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('subscriptions.index') }}">Volver</a>
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

            var num = ctrl.value.replace(/\./g,'');
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            ctrl.value = num;
        }

        function formatPriceForInput(total) {
            var num = total.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');

            return num;
        }

        function checkNumeric() {
            return event.keyCode >= 48 && event.keyCode <= 57;
        }

        $(function () {
            $('#course_id').change(function () {
                let text = $(this).find("option:selected").text();
                let period = text.substring(
                    text.lastIndexOf("(") + 1,
                    text.lastIndexOf(")")
                );

                $('#period').val(period);
            });

            $('#start_date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                iconsLibrary: 'fontawesome'
            });

            $('#end_date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                iconsLibrary: 'fontawesome',
                minDate: function() {
                    return $('#start_date').val();
                }
            });

            $('#student_id').select2({
                theme: 'bootstrap4'
            });

            $('#course_id').change(function () {
                let id = $(this).val();

                if (id) {
                    let url = route('subscriptions.get_course', id);

                    $.get(url, function (data) {
                        $('#total').val(formatPriceForInput(data['price']));
                    });
                } else {
                    $('#total').val('');
                }
            });
        });
    </script>
@endsection
