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
                            <h3 class="card-title">Cuadrar caja</h3>
                        </div>

                        <form action="{{ route('money_closures.store') }}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="date">Fecha</label>
                                            <input name="date" id="date"
                                                class="form-control @error('date') is-invalid @enderror"
                                                value="{{ old('date') }}" autocomplete="off" placeholder="Ingrese fecha">
                                            @error('date')
                                                <span
                                                    style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="stadium_id">Cancha</label>
                                            <select name="stadium_id" id="stadium_id" class="form-control @error('stadium_id') is-invalid @enderror">
                                                <option value="" selected>Seleccione</option>
                                                @foreach ($stadiums as $stadium)
                                                    <option value="{{ $stadium->id }}">{{ $stadium->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('stadium_id')
                                                <span
                                                    style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label for="cash_collected_total">Efectivo Recaudado</label>
                                                            <input
                                                                type="text"
                                                                class="form-control @error('cash_collected_total') is-invalid @enderror"
                                                                name="cash_collected_total"
                                                                id="cash_collected_total"
                                                                autocomplete="off"
                                                                onkeypress="return checkNumeric();"
                                                                onkeyup="formatPrice(this);"
                                                                placeholder="Ingrese monto"
                                                                value="{{ old('cash_collected_total') }}"
                                                            >
                                                        </td>
                                                        <td width="5%">
                                                            <h4 class="text-center" style="margin-top: 2.2rem;">
                                                                <span class="badge badge-secondary">
                                                                    <i class="fas fa-arrow-right"></i>
                                                                </span>
                                                            </h4>
                                                        </td>
                                                        <td>
                                                            <label for="cash_real_total">Efectivo Real</label>
                                                            <input
                                                                readonly
                                                                type="text"
                                                                name="cash_real_total"
                                                                id="cash_real_total"
                                                                class="form-control" value="{{ old('cash_real_total') }}"
                                                            >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="transfer_collected_total">Trans. Recaudado</label>
                                                            <input
                                                                type="text"
                                                                class="form-control @error('transfer_collected_total') is-invalid @enderror"
                                                                name="transfer_collected_total"
                                                                id="transfer_collected_total"
                                                                autocomplete="off"
                                                                onkeypress="return checkNumeric();"
                                                                onkeyup="formatPrice(this);"
                                                                placeholder="Ingrese monto"
                                                                value="{{ old('transfer_collected_total') }}"
                                                            >
                                                        </td>
                                                        <td width="5%">
                                                            <h4 class="text-center" style="margin-top: 2.2rem;">
                                                                <span class="badge badge-secondary">
                                                                    <i class="fas fa-arrow-right"></i>
                                                                </span>
                                                            </h4>
                                                        </td>
                                                        <td>
                                                            <label for="transfer_real_total">Trans. Real</label>
                                                            <input
                                                                readonly
                                                                type="text"
                                                                name="transfer_real_total"
                                                                id="transfer_real_total"
                                                                class="form-control" value="{{ old('transfer_real_total') }}"
                                                            >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="debt_collected_total">Débito Recaudado</label>
                                                            <input
                                                                type="text"
                                                                class="form-control @error('debt_collected_total') is-invalid @enderror"
                                                                name="debt_collected_total"
                                                                id="debt_collected_total"
                                                                autocomplete="off"
                                                                onkeypress="return checkNumeric();"
                                                                onkeyup="formatPrice(this);"
                                                                placeholder="Ingrese monto"
                                                                value="{{ old('debt_collected_total') }}"
                                                            >
                                                        </td>
                                                        <td width="5%">
                                                            <h4 class="text-center" style="margin-top: 2.2rem;">
                                                                <span class="badge badge-secondary">
                                                                    <i class="fas fa-arrow-right"></i>
                                                                </span>
                                                            </h4>
                                                        </td>
                                                        <td>
                                                            <label for="debt_real_total">Débito Real</label>
                                                            <input
                                                                readonly
                                                                type="text"
                                                                name="debt_real_total"
                                                                id="debt_real_total"
                                                                class="form-control" value="{{ old('debt_real_total') }}"
                                                            >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="credit_collected_total">Crédito Recaudado</label>
                                                            <input
                                                                type="text"
                                                                class="form-control @error('credit_collected_total') is-invalid @enderror"
                                                                name="credit_collected_total"
                                                                id="credit_collected_total"
                                                                autocomplete="off"
                                                                onkeypress="return checkNumeric();"
                                                                onkeyup="formatPrice(this);"
                                                                placeholder="Ingrese monto"
                                                                value="{{ old('credit_collected_total') }}"
                                                            >
                                                        </td>
                                                        <td width="5%">
                                                            <h4 class="text-center" style="margin-top: 2.2rem;">
                                                                <span class="badge badge-secondary">
                                                                    <i class="fas fa-arrow-right"></i>
                                                                </span>
                                                            </h4>
                                                        </td>
                                                        <td>
                                                            <label for="credit_real_total">Crédito Real</label>
                                                            <input
                                                                readonly
                                                                type="text"
                                                                name="credit_real_total"
                                                                id="credit_real_total"
                                                                class="form-control" value="{{ old('credit_real_total') }}"
                                                            >
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('money_closures.index') }}">Volver</a>
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

        function formatPriceForInput(total) {
            var num = total.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/, '');

            return num;
        }

        function checkNumeric() {
            return event.keyCode >= 48 && event.keyCode <= 57;
        }

        $(function() {
            $('#date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                iconsLibrary: 'fontawesome'
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#stadium_id').change(function () {
                let date = $('#date').val();
                let stadium_id = $(this).val();
                let url = route('money_closures.get_real_total', {date, stadium_id});

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        $('#cash_real_total').val(formatPriceForInput(data['total_cash_real']));
                        $('#transfer_real_total').val(formatPriceForInput(data['total_transfer_real']));
                        $('#debt_real_total').val(formatPriceForInput(data['total_debt_real']));
                        $('#credit_real_total').val(formatPriceForInput(data['total_credit_real']));
                    }
                });
            });
        });
    </script>
@endsection
