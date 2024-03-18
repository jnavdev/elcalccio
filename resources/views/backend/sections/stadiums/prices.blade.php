@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Actualizar Precios {{ $stadium->name }}</h1>
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
                            <h3 class="card-title">Días</h3>
                        </div>

                        <form action="{{ route('stadium_prices.store', $stadium->id) }}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h5 class="mb-3"><span class="badge badge-primary">Lunes - Viernes</span></h5>
                                        <table class="table table-bordered mt-2" id="table">
                                            <thead>
                                                <tr>
                                                    <th>Hora</th>
                                                    <th>Precio</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($hours as $key => $value)
                                                    @if ($stadium->stadiumPrices->count())
                                                        <tr>
                                                            <td>{{ $value }}</td>
                                                            <td>
                                                                <input
                                                                    name="hoursWeekendNo[{{ $value }}]"
                                                                    class="form-control"
                                                                    type="text"
                                                                    onkeypress="return checkNumeric();"
                                                                    onkeyup="formatPrice(this);"
                                                                    value="{{ chileanPeso($stadium->stadiumPrices()->where('hour', $value)->where('is_weekend', false)->first()->price) }}"
                                                                >
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>{{ $value }}</td>
                                                            <td>
                                                                <input
                                                                    name="hoursWeekendNo[{{ $value }}]"
                                                                    class="form-control"
                                                                    type="text"
                                                                    onkeypress="return checkNumeric();"
                                                                    onkeyup="formatPrice(this);"
                                                                    value="0"
                                                                >
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-sm-6">
                                        <h5 class="mb-3"><span class="badge badge-primary">Sábado - Domingo</span></h5>
                                        <table class="table table-bordered mt-2" id="table">
                                            <thead>
                                                <tr>
                                                    <th>Hora</th>
                                                    <th>Precio</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($hours as $key => $value)
                                                    @if ($stadium->stadiumPrices->count())
                                                        <tr>
                                                            <td>{{ $value }}</td>
                                                            <td>
                                                                <input
                                                                    name="hoursWeekendYes[{{ $value }}]"
                                                                    class="form-control"
                                                                    type="text"
                                                                    onkeypress="return checkNumeric();"
                                                                    onkeyup="formatPrice(this);"
                                                                    value="{{ chileanPeso($stadium->stadiumPrices()->where('hour', $value)->where('is_weekend', true)->first()->price) }}"
                                                                >
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>{{ $value }}</td>
                                                            <td>
                                                                <input
                                                                    name="hoursWeekendYes[{{ $value }}]"
                                                                    class="form-control"
                                                                    type="text"
                                                                    onkeypress="return checkNumeric();"
                                                                    onkeyup="formatPrice(this);"
                                                                    value="0"
                                                                >
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('stadiums.index') }}">Volver</a>
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
