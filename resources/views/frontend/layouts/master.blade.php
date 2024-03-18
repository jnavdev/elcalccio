<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>{{ config('app.name') }} - Complejo Deportivo</title>
    <meta name="keywords" content="Arriendo de canchas, escuela de futbol, puerto varas" />
    <meta name="description"
        content="Arriendo de Canchas, Escuela de futbol puerto varas, entrenamiento funcional, entrenamiento para adultos, arriendo de canchas puerto varas" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">

    <!--Google Fonts CSS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100;200;300;400;500;600;700;800;900&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!--Font Awesome Icon CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/font-awesome.min.css') }}">

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/slick-theme.css') }}">

    <!-- Wow Animation CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/animate.min.css') }}">

    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/magnific-popup.min.css') }}">

    <!-- Main Style CSS  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/style.css') }}">

    <!-- Loader CSS  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/loader.css') }}">

    <!-- Whatsapp CSS  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/whatsapp.css') }}">

    @yield('css')
</head>

<body>
    <div class="lds-roller" style="display: none;">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Loader Start -->
    <div class="loader-box">
        <div class="loader-text">
            <span class="let1">C</span>
            <span class="let2">a</span>
            <span class="let3">l</span>
            <span class="let4">c</span>
            <span class="let5">c</span>
            <span class="let6">i</span>
            <span class="let7">o</span>
            <span class="let8">.</span>
            <span class="let9">.</span>
            <span class="let10">.</span>
        </div>
    </div>
    <!-- Loader End -->

    <!-- Header Start -->
    <header class="site-header">
        <!--Navbar Start  -->
        <div class="header-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-2">
                        <!-- Sit Logo Start -->
                        <div class="site-branding">
                            <a href="{{ route('frontend.home') }}">
                                <img src="{{ asset('assets/frontend/images/ElCalccio.png') }}" alt="Logo El Calccio">
                                <img src="{{ asset('assets/frontend/images/ElCalccio.png') }}" class="sticky-logo"
                                    alt="Logo">
                            </a>
                        </div>
                        <!-- Sit Logo End -->
                    </div>
                    <div class="col-lg-10">
                        <div class="header-menu">
                            <nav class="main-navigation two">
                                <button class="toggle-button">
                                    <span></span>
                                    <span class="toggle-width"></span>
                                    <span></span>
                                </button>
                                <div class="mobile-menu-box">
                                    <i class="menu-background top"></i>
                                    <i class="menu-background middle"></i>
                                    <i class="menu-background bottom"></i>
                                    <ul class="menu">
                                        <li>
                                            <a href="{{ route('frontend.home') }}" title="Home">Home</a>
                                        </li>
                                        <li>
                                            <a href="http://www.versusproducciones.cl/" target="_blank">Ligas</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('frontend.articles.index') }}"
                                                title="Blog">Noticias</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('frontend.reservations_calendar') }}">Reserva tu
                                                hora</a>
                                        </li>
                                        @if (auth()->check() && auth()->user()->role_id == 2)
                                            <li class="sub-items">
                                                <a href="javascript:void(0);">{{ auth()->user()->name }}</a>
                                                <ul class="sub-menu">
                                                    <li>
                                                        <a href="{{ route('frontend.my_account.index') }}">Mi
                                                            Cuenta</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('logout') }}"
                                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>
                                                    </li>

                                                    <form id="logout-form" action="{{ route('logout') }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </ul>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ route('frontend.login.view') }}">Ingresar</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </nav>
                            <div class="header-search-box two">
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#search-modal"
                                    class="header-search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="black-shadow"></div>
                            <!--  <div class="header-btn-two">
                                <a href="contact-us.html" class="sec-btn">Join Now</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Navbar End  -->
    </header>
    <!-- Header End -->

    @yield('content')

    <!--Footer Start-->
    <footer class="main-footer">
        <div class="footer-overlay-bg animate-this">
            <img src="{{ asset('assets/frontend/images/footer-overlay.png') }}" alt="Overlay">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-box-one">
                        <a href="index.html">
                            <img src="{{ asset('assets/frontend/images/ElCalccioBlanco.png') }}" alt="Fithub">
                        </a>
                        <p>Complejo deportivo El Calccio Puerto Varas.</p>
                        <div class="footer-time">
                            <img src="{{ asset('assets/frontend/images/clock-2.png') }}" alt="Clock">
                            <div class="footer-time-text-box">
                                <div class="footer-time-text">
                                    <span>Lunes - Domingo</span>
                                    <span>9:00Am - 24:00Pm</span>
                                </div>
                                <!--  <div class="footer-time-text mt-3">
                                    <span>Saturday - Sunday</span>
                                    <span>7:00Am - 2:00Pm</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-box-two">
                        <h3 class="h3-title">Links</h3>
                        <div class="line"></div>
                        <ul>
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li><a href="#">Escuela de Futbol</a></li>
                            <li><a href="#">Academia Calccio</a></li>
                            <li><a href="#">Noticias</a></li>
                            <li><a href="#">Contacto</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-box-three">
                        <h3 class="h3-title">Contacto</h3>
                        <div class="line"></div>
                        <ul>
                            <li>
                                <div class="footer-contact-icon">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                </div>
                                <div class="footer-contact-text">
                                    <span>Camino La Laja, Parcela N2, Puerto Varas, Chile</span>
                                </div>
                            </li>
                            <li>
                                <div class="footer-contact-icon">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                </div>
                                <div class="footer-contact-text">
                                    < <span>+56 9 7748 0252 </span>
                                </div>
                            </li>
                            <li>
                                <div class="footer-contact-icon">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </div>
                                <div class="footer-contact-text">
                                    <span>administracion@elcalccio.cl</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-box-four">
                        <h3 class="h3-title">Nuestro Newsletter</h3>
                        <div class="line"></div>
                        <div class="footer-subscribe-form">
                            <input type="email" name="email" class="form-input subscribe-input"
                                placeholder="Email" required="">
                            <button type="submit" class="sec-btn"><i class="fa fa-chevron-right"></i></button>
                        </div>
                        <div class="footer-social">
                            <ul>
                                <li><a href="https://www.facebook.com/elcalcciopuertovaras" target="_blank"><i
                                            class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="https://www.instagram.com/elcalccio/" target="_blank"><i
                                            class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                <li><a href="#" target="_blank"><i class="fa fa-youtube"
                                            aria-hidden="true"></i></a></li>


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-7">
                        <div class="copyright-text">
                            <span>Marca registrada © 2022 Calccio SPA. Todos los derechos reservados.</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="copyright-links">
                            <!--  <ul>
                                <li><a href="about-us.html">Privacy Policy</a></li>
                                <li><a href="about-us.html">Team &amp; Condition</a></li>
                            </ul> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--Footer End-->

    <!-- modal-search-start -->
    <div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
        </button>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('frontend.articles.index') }}">
                    <input type="text" placeholder="Escriba aqui..." name="title">
                    <button>
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- modal-search-end -->

    <a href="https://wa.me/56977480252" class="float bounce" target="_blank"> <i
            class="fa fa-whatsapp my-float"></i></a>

    @routes

    <!-- Jquery JS Link -->
    <script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>

    <!-- Bootstrap JS Link -->
    <script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/popper.min.js') }}"></script>

    <!-- Custom JS Link -->
    <script src="{{ asset('assets/frontend/js/custom.js') }}"></script>

    <!-- Slick Slider JS Link -->
    <script src="{{ asset('assets/frontend/js/slick.min.js') }}"></script>

    <!-- Wow Animation JS -->
    <script src="{{ asset('assets/frontend/js/wow.min.js') }}"></script>

    <!--Magnific Popup JS-->
    <script src="{{ asset('assets/frontend/js/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/custom-magnific-popup.js') }}"></script>

    <!--Momentjs-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <!-- Rut JS -->
    <script src="{{ asset('assets/frontend/js/rut.js') }}"></script>

    @yield('js')
</body>

</html>
