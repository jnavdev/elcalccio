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
                            <h3 class="card-title">Cuadrar caja</h3>
                        </div>

                        <form action="{{ route('money_closures.update', $moneyClosure) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="user">Responsable</label>
                                            <input name="user" id="user"
                                                class="form-control"
                                                value="{{ $moneyClosure->user->name }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="date">Fecha</label>
                                            <input name="date" id="date"
                                                class="form-control"
                                                value="{{ $moneyClosure->date->format('d-m-Y') }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="cash_collected_total">Total efectivo recaudado</label>
                                            <input autocomplete="off" type="text" name="cash_collected_total"
                                                id="cash_collected_total" class="form-control @error('cash_collected_total') is-invalid @enderror"
                                                onkeypress="return checkNumeric();" onkeyup="formatPrice(this);" placeholder="Ingrese monto" value="{{ old('cash_collected_total', chileanPeso($moneyClosure->cash_collected_total)) }}">
                                            @error('cash_collected_total')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2" style="margin-top: 20px; padding-left: 107px;">
                                        <span style="font-size: 40px; color: Dodgerblue;">
                                            <i class="fas fa-arrow-right"></i>
                                          </span>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="cash_real_total">Total efectivo real</label>
                                            <input readonly type="text" name="cash_real_total" id="cash_real_total"
                                                class="form-control" value="{{ chileanPeso($moneyClosure->cash_real_total) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="section">
                                            <label for="cash_collected_total">Total transferencias recaudado</label>
                                            <input autocomplete="off" type="text" name="transfer_collected_total"
                                                id="transfer_collected_total" class="form-control @error('transfer_collected_total') is-invalid @enderror"
                                                onkeypress="return checkNumeric();" onkeyup="formatPrice(this);" placeholder="Ingrese monto" value="{{ old('transfer_collected_total', chileanPeso($moneyClosure->transfer_collected_total)) }}">
                                            @error('transfer_collected_total')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2" style="margin-top: 20px; padding-left: 107px;">
                                        <span style="font-size: 40px; color: Dodgerblue;">
                                            <i class="fas fa-arrow-right"></i>
                                          </span>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="section">
                                            <label for="transfer_real_total">Total transferencias real</label>
                                            <input readonly type="text" name="transfer_real_total"
                                                id="transfer_real_total" class="form-control" value="{{ chileanPeso($moneyClosure->transfer_real_total) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="section">
                                            <label for="debt_collected_total">Total debito recaudado</label>
                                            <input autocomplete="off" type="text" name="debt_collected_total"
                                                id="debt_collected_total" class="form-control @error('debt_collected_total') is-invalid @enderror"
                                                onkeypress="return checkNumeric();" onkeyup="formatPrice(this);" placeholder="Ingrese monto" value="{{ old('debt_collected_total', chileanPeso($moneyClosure->debt_collected_total)) }}">
                                            @error('debt_collected_total')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2" style="margin-top: 20px; padding-left: 107px;">
                                        <span style="font-size: 40px; color: Dodgerblue;">
                                            <i class="fas fa-arrow-right"></i>
                                          </span>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="section">
                                            <label for="debt_real_total">Total debito real</label>
                                            <input readonly type="text" name="debt_real_total" id="debt_real_total"
                                                class="form-control" value="{{ chileanPeso($moneyClosure->debt_real_total) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="section">
                                            <label for="credit_collected_total">Total credito recaudado</label>
                                            <input autocomplete="off" type="text" name="credit_collected_total"
                                                id="credit_collected_total" class="form-control @error('credit_collected_total') is-invalid @enderror"
                                                onkeypress="return checkNumeric();" onkeyup="formatPrice(this);" placeholder="Ingrese monto" value="{{ old('credit_collected_total', chileanPeso($moneyClosure->credit_collected_total)) }}">
                                            @error('credit_collected_total')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2" style="margin-top: 20px; padding-left: 107px;">
                                        <span style="font-size: 40px; color: Dodgerblue;">
                                            <i class="fas fa-arrow-right"></i>
                                          </span>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="section">
                                            <label for="credit_real_total">Total credito real</label>
                                            <input readonly type="text" name="credit_real_total"
                                                id="credit_real_total" class="form-control" value="{{ chileanPeso($moneyClosure->credit_real_total) }}">
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

        function checkNumeric() {
            return event.keyCode >= 48 && event.keyCode <= 57;
        }
    </script>
@endsection
