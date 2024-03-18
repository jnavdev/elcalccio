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
                            <h3 class="card-title">Reserva</h3>
                        </div>

                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="date">Fecha</label>
                                            <input name="date" id="datepicker" autocomplete="off"
                                                value="{{ request('date') ? request('date') : now()->format('d-m-Y') }}"
                                                data-min-date="{{ now()->format('d-m-Y') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="stadium">Cancha</label>
                                            <select name="stadium" id="select_stadium_id" class="form-control">
                                                @foreach ($stadiums as $stadium)
                                                    <option value="{{ $stadium->id }}"
                                                        {{ request('stadium_id') ? (request('stadium_id') == $stadium->id ? 'selected' : '') : '' }}>
                                                        {{ $stadium->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-12">
                                        {!! $table !!}
                                        @error('res')
                                            <span
                                                style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr>

                                <h4><span class="badge badge-primary">Pago</span></h4>

                                <div class="row">
                                    <div class="col-sm-12">
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
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="total">Total</label>
                                            <input type="text" name="total" id="total" value="{{ old('total') }}" class="form-control @error('total') is-invalid @enderror"
                                                onkeypress="return checkNumeric();" onkeyup="formatPrice(this);" placeholder="Total de la reserva">
                                            @error('total')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="advancement">Abono</label>
                                            <input type="text" name="advancement" id="advancement" value="{{ old('advancement') }}"
                                                class="form-control @error('advancement') is-invalid @enderror" onkeypress="return checkNumeric();"
                                                onkeyup="formatPrice(this);" placeholder="Abono de la reserva">
                                            @error('advancement')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h4><span class="badge badge-primary">Cliente</span></h4>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="rut">RUT</label>
                                            <input type="text" name="rut" id="rut" class="form-control @error('rut') is-invalid @enderror"
                                                placeholder="Ingrese RUT" value="{{ old('rut') }}">
                                            @error('rut')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Ingrese nombre" value="{{ old('name') }}">
                                            @error('name')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Ingrese email" value="{{ old('email') }}">
                                            @error('email')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="phone">Teléfono</label>
                                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                                placeholder="Ingrese telefono" value="{{ old('phone') }}">
                                            @error('phone')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('reservations.index') }}">Volver</a>
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
        var totalReservation = 0;

        function formatPrice(ctrl) {
            if (event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40) {
                return;
            }

            var num = ctrl.value.replace(/\./g, '');
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/, '');
            ctrl.value = num;
        }

        function formatPriceForInput(total) {
            var num = total.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/, '');

            return num;
        }

        function checkNumeric() {
            return event.keyCode >= 48 && event.keyCode <= 57;
        }

        $(function() {
            $('#datepicker').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                iconsLibrary: 'fontawesome'
            });

            var lastDatepickerSelected = $('#datepicker').val();
            $('#datepicker').change(function(e) {
                if (lastDatepickerSelected !== e.target.value) {
                    $('.lds-roller').css('display', 'block');
                    window.location.href = route('reservations.create', [$(this).val(), $(
                        '#select_stadium_id').val()]);
                }
            });

            $('#select_stadium_id').change(function() {
                $('.lds-roller').css('display', 'block');
                window.location.href = route('reservations.create', [$('#datepicker').val(), $(this)
            .val()]);
            });

            $('#rut').on('change', function(e) {
                $(this).val(format(e.target.value));
            });

            $('#rut').focusout(function() {
                var url = route('reservations.search_customer');
                var rut = $(this).val();

                $('#name').val('');
                $('#email').val('');
                $('#phone').val('');

                if (rut) {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            rut: rut
                        },
                        dataType: 'json',
                        beforeSend: function(xhr) {
                            $('.lds-roller').css('display', 'block');
                        },
                        success: function(response) {
                            if (response['success']) {
                                $('#name').val(response['customer']['name']);
                                $('#email').val(response['customer']['email']);
                                $('#phone').val(response['customer']['phone']);
                            }
                            $('.lds-roller').css('display', 'none');
                        }
                    });
                }
            });

            $("input[type='checkbox']").change(function() {
                var ischecked = $(this).is(':checked');
                var inputValue = $(this).val();
                var splittedValue = inputValue.split('_');
                var price = parseInt(splittedValue[2]);

                if (ischecked) {
                    totalReservation = totalReservation + price;
                } else {
                    totalReservation = totalReservation - price;
                }

                $('#total').val(formatPriceForInput(totalReservation));
            });
        });
    </script>
@endsection
