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
                            <h3 class="card-title">Movimiento</h3>
                        </div>

                        <form action="{{ route('movements.store') }}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="date">Fecha</label>
                                            <input name="date" id="date"
                                                class="form-control @error('date') is-invalid @enderror"
                                                value="{{ old('date', now()->format('d-m-Y')) }}" autocomplete="off" placeholder="Ingrese fecha">
                                            @error('date')
                                                <span
                                                    style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="amount">Monto</label>
                                            <input type="text" name="amount" id="amount" value="{{ old('amount') }}"
                                                class="form-control @error('amount') is-invalid @enderror"
                                                onkeypress="return checkNumeric();" onkeyup="formatPrice(this);"
                                                placeholder="Ingrese monto" autocomplete="off">
                                            @error('amount')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="concept_type">Tipo</label>
                                            <select name="concept_type" id="concept_type" class="form-control">
                                                <option value="Ingreso" selected>Ingreso</option>
                                                <option value="Gasto">Gasto</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group" id="select_incomes">
                                            <label for="concept_id_income">Concepto</label>
                                            <select name="concept_id_income" id="concept_id_income"
                                                class="form-control @error('concept_id_income') is-invalid @enderror">
                                                <option value="" selected>Seleccione</option>
                                                @foreach ($incomes as $income)
                                                    <option value="{{ $income->id }}">{{ $income->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('concept_id_income')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group" id="select_expenses" style="display: none;">
                                            <label for="concept_id_expense">Concepto</label>
                                            <select name="concept_id_expense" id="concept_id_expense"
                                                class="form-control @error('concept_id_expense') is-invalid @enderror">
                                                <option value="" selected>Seleccione</option>
                                                @foreach ($expenses as $expense)
                                                    <option value="{{ $expense->id }}">{{ $expense->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('concept_id_expense')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <strong>Forma de Pago</strong>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_type"
                                                id="payment_type_cash" value="cash" checked>
                                            <label class="form-check-label" for="payment_type_cash">
                                                Efectivo
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_type"
                                                id="payment_type_bank" value="bank">
                                            <label class="form-check-label" for="payment_type_bank">
                                                Cuenta Bancaria
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6" id="div_payment_methods" style="display: none;">
                                        <div class="form-group">
                                            <label for="payment_method_id">Cuenta Bancaria</label>
                                            <select name="payment_method_id" id="payment_method_id"
                                                class="form-control @error('payment_method_id') is-invalid @enderror">
                                                <option value="" selected>Seleccione</option>
                                                @foreach ($paymentMethods as $paymentMethod)
                                                    <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->bank }} -
                                                        {{ $paymentMethod->account_number }}</option>
                                                @endforeach
                                            </select>
                                            @error('payment_method_id')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="description">Descripcion</label>
                                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('movements.index') }}">Volver</a>
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

            $('#concept_type').change(function() {
                let type = $(this).val();

                if (type == 'Ingreso') {
                    $('#select_incomes').show();
                    $('#select_expenses').hide();
                } else if (type == 'Gasto') {
                    $('#select_expenses').show();
                    $('#select_incomes').hide();
                }
            });

            $('input[type=radio][name=payment_type]').change(function() {
                let type = $(this).val();

                if (type == 'cash') {
                    $('#div_payment_methods').hide();
                } else if (type == 'bank') {
                    $('#div_payment_methods').show();
                }
            });
        });
    </script>
@endsection
