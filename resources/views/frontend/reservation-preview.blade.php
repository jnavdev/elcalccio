@extends('frontend.layouts.master')

@section('content')
    <!--Banner Start-->
    <section class="main-inner-banner jarallax" data-jarallax data-speed="0.2" data-imgPosition="20% 0%"
        style="background-image: url({{ asset('assets/frontend/images/fondo-calendario-reservas.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-in-title">
                        <h1 class="h1-title">Reserva</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Banner End-->

    <!--Blog Detail Start-->
    <section class="main-blog-detail">
        <div class="container">
            <div class="row justify-content-center">
                <!--Blog Detail info Start-->
                <div class="col-lg-12">
                    @if ($reservationData)
                        <h4 class="mb-4">Detalle</h4>

                        <div class="card">
                            <div class="card-body">
                                Lugar: {{ $reservationData['stadium_name'] }}
                            </div>
                        </div>

                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                    <th>Hora</th>
                                    <th>Fecha</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservationData['reservations']['data'] as $data)
                                    <tr>
                                        <td>{{ $data['hour'] }}</td>
                                        <td>{{ $data['date'] }}</td>
                                        <td>{{ '$' . chileanPeso($data['price']) }}</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td colspan="2">Total</td>
                                    <th>{{ '$' . chileanPeso($reservationData['total']) }}</th>
                                </tr>
                            </tbody>
                        </table>

                        <button type="button" class="btn btn-warning mt-2" data-bs-toggle="modal"
                            data-bs-target="#reservationModal">Reservar</button>

                        <form action="{{ route('frontend.reservations_store') }}" method="POST" id="form-store-reservation"
                            style="display: none;">
                            @csrf
                        </form>
                    @else
                        <h4 class="mt-5 mb-5">Reserva no encontrada!</h4>
                    @endif
                </div>
                <!--Blog Detail info End-->
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Información importante</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Una vez confirmada la reserva deberá realizar el pago en el recinto.</p>
                        <h6>Confirmar reserva?</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            style="background-color: #dc3545;">Cancelar</button>
                        <button id="button-confirm-reservation" type="button" class="btn btn-primary"
                            style="background-color: #0d6efd;">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Blog Detail End-->
@endsection

@section('js')
    <script>
        $(function() {
            $('#button-confirm-reservation').click(function() {
                $('#form-store-reservation').submit();
            });
        });
    </script>
@endsection
