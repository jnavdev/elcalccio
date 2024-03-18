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
                        <h1 class="h1-title">Mi cuenta</h1>
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
                            <h5>Mis reservas</h5>

                            @if ($reservations->count())
                                <table class="table table-bordered mt-4 mb-4">
                                    <thead>
                                        <tr>
                                            <th>Lugar</th>
                                            <th>Horas</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservations as $reservation)
                                            <tr>
                                                <td>{{ $reservation->stadium->name }}</td>
                                                <td>
                                                    <ul class="list-group">
                                                        @foreach ($reservation->reservationItems as $reservationItem)
                                                            <li class="list-group-item">
                                                                <i class="fa fa-check"></i>
                                                                Fecha: {{ $reservationItem->date->format('d-m-Y') }},
                                                                Hora: {{ $reservationItem->hour }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{ '$' . chileanPeso($reservation->total) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $reservations->links('vendor.pagination.bootstrap-5') }}
                            @else
                                <h5 class="text-center" style="margin-top: 100px; margin-bottom: 100px;">Sin reservas.</h5>
                            @endif
                        </div>
                    </div>
                </div>
                <!--Class Detail Info End-->
            </div>
        </div>
    </section>
    <!--Class Detail End-->
@endsection
