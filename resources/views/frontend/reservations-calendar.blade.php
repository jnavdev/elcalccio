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
                        <h1 class="h1-title">Reserva tu hora</h1>
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
                    <div class="download-brochure wow fadeInLeft" data-wow-delay=".3s">
                        <h3 class="h3-title">Filtrar calendario</h3>
                        <div class="line"></div>
                        <div class="mb-3 mt-4">
                            <label for="date" class="form-label">Fecha</label>
                            <input name="date" id="datepicker" autocomplete="off"
                                value="{{ request('date') ? request('date') : now()->format('d-m-Y') }}"
                                data-min-date="{{ now()->format('d-m-Y') }}">
                        </div>
                        <div class="mb-3">
                            <label for="stadium" class="form-label">Cancha</label>
                            <select name="stadium" id="select_stadium_id" class="form-control">
                                @foreach ($stadiums as $stadium)
                                    <option value="{{ $stadium->id }}"
                                        {{ request('stadium_id') ? (request('stadium_id') == $stadium->id ? 'selected' : '') : '' }}>
                                        {{ $stadium->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if (auth()->check() && auth()->user()->role_id == 2)
                            <div class="d-grid gap-2">
                                <button id="btnSaveReservation" class="btn btn-block btn-warning mt-2"
                                    type="button">Reservar!</button>

                                <div class="alert alert-danger mt-3" id="div-error" style="display: none;">
                                    <strong>Debe seleccionar al menos una hora!</strong>
                                </div>
                            </div>
                        @else
                            <h3 class="h3-title mt-4">Quiero reservar!</h3>
                            <div class="line"></div>
                            <div class="row">
                                <div class="col-12">
                                    <p style="color: black;">Agenda tu hora llamando a <strong>+56 9 7748 0252</strong> o a
                                        través
                                        de nuestro botón de WhatsApp</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!--Sidebar End-->
                <!--Class Detail Info Start-->
                <div class="col-lg-9">
                    <h2
                        style="font-family: 'Catamaran', sans-serif; font-size: 50px; font-weight: 700; padding-bottom: 34px; margin-top: 30px;">
                        Horas disponibles</h2>
                    <div class="table-responsive">
                        {!! $table !!}
                    </div>
                </div>
                <!--Class Detail Info End-->
            </div>
        </div>
    </section>
    <!--Class Detail End-->
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.13/js/gijgo.min.js"></script>
    <script>
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
                    window.location.href = route('frontend.reservations_calendar', [$(this).val(), $(
                        '#select_stadium_id').val()]);
                }
            });

            $('#select_stadium_id').change(function() {
                $('.lds-roller').css('display', 'block');
                window.location.href = route('frontend.reservations_calendar', [$('#datepicker').val(), $(
                        this)
                    .val()
                ]);
            });

            $('#btnSaveReservation').click(function() {
                $('#div-error').css('display', 'none');

                var res = [];
                $("[name='res[]']:checked").each(function(i) {
                    res[i] = $(this).val();
                });

                var formData = new FormData();
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                formData.append('stadium', $('#select_stadium_id').val());
                formData.append('res', res);

                $.ajax({
                    url: route('frontend.reservations_save'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        window.location.href = route('frontend.reservations_preview');
                    },
                    error: function(res) {
                        if (res.status === 422) {
                            $('#div-error').css('display', 'block');
                        }
                    }
                });
            });
        });
    </script>
@endsection
