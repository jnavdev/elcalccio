@extends('frontend.layouts.master')

@section('content')
    <!--Banner Start-->
    <section class="main-banner-two">
        <div class="banner-two-circle-one"></div>
        <div class="banner-two-circle-two"></div>
        <div class="banner-two-circle-three"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="banner-title-two">
                        <div class="main-banner-subtitle-box wow fadeInUp" data-wow-delay=".5s">
                            <div class="banner-subtitle-box">
                             <div class="banner-subtitle-first">Complejo Deportivo</div>
                             <div class="banner-subtitle-second">El Calccio</div>
                            </div>
                         </div>
                         <h1 class="h1-title wow fadeInUp" data-wow-delay=".7s"> Deporte <span>y recreación</span></h1>
                        <p class="wow fadeInUp" data-wow-delay=".9s">Solicita tu hora llamando al + 56 9 7748 0252 o por WhatsApp. Ven a jugar a nuestras canchas con medidas oficiales de Fútbol 7 (F7)</p>
                        <div class="banner-btn-two wow fadeInUp" data-wow-delay="1s">
                            <a href="https://www.youtube.com/watch?v=E3vqucJ-dKQ;" class="sec-btn wow fadeInUp  popup-youtube" data-wow-delay="1s">Video</a>
                            <a href="https://www.youtube.com/watch?v=E3vqucJ-dKQ;" class="banner-play-btn popup-youtube"><i class="fa fa-play" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-banner-img-two wow fadeInRight" data-wow-delay=".5s">
                       <img src="{{ asset('assets/frontend/images/portfolio-img1.jpg') }}" alt="Banner">
                        <div class="banner-img-circle-two animate-this">
                           <!--  <img src="assets/images/banner-img-circle-bg.png" alt="Circle"> -->
                        </div>
                        <div class="heart-rate-two">
                            <div class="heart-icon">
                               <img src="{{ asset('assets/frontend/images/heart-rate-2.png') }}" alt="Heart Rate">
                            </div>
                            <div class="heart-text">
                                <span>El deporte</span>
                                <h3>es Salud.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Banner End-->



    <!--Features Start-->
    <section class="main-features">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-box wow fadeInUp" data-wow-delay=".5s">
                        <span>01</span>
                        <div class="feature-icon">
                            <img src="{{ asset('assets/frontend/images/feature-1.png') }}" alt="Icon">
                        </div>
                        <div class="feature-text">
                            <h3 class="h3-title">Controlar el peso</h3>
                            <p>El ejercicio puede ayudar a prevenir el aumento de peso excesivo.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-box wow fadeInDown" data-wow-delay=".5s">
                        <span>02</span>
                        <div class="feature-icon">
                            <img src="{{ asset('assets/frontend/images/feature-2.png') }}" alt="Icon">
                        </div>
                        <div class="feature-text">
                            <h3 class="h3-title">Mejora el Animo</h3>
                            <p>¿Necesitas un estímulo emocional?  </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-box wow fadeInUp" data-wow-delay=".5s">
                        <span>03</span>
                        <div class="feature-icon">
                            <img src="{{ asset('assets/frontend/images/feature-3.png') }}" alt="Icon">
                        </div>
                        <div class="feature-text">
                            <h3 class="h3-title">Mejora del sueño</h3>
                            <p>¿Te cuesta dormir? La actividad física regular puede ayudar.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-box wow fadeInDown" data-wow-delay=".5s">
                        <span>04</span>
                        <div class="feature-icon">
                            <img src="{{ asset('assets/frontend/images/feature-4.png') }}" alt="Icon">
                        </div>
                        <div class="feature-text">
                            <h3 class="h3-title">Aumento de Energía</h3>
                            <p>Tienes más energía para hacer las tareas diarias.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Features End-->

    <!--About Us Start-->
  <!--   <section class="main-about-us-two">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-img-two wow fadeInLeft" data-wow-delay=".5s">
                        <img src="assets/images/about-img-two.png" alt="About Us">
                        <div class="about-img-bg-circle-two"></div>
                        <div class="about-client">
                            <div class="about-client-content">
                                <span>150k+ Clients</span>
                                <img src="assets/images/about-client.png" alt="Clients">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content-box two wow fadeInRight" data-wow-delay=".5s">
                        <div class="about-us-title">
                            <div class="subtitle">
                                <h2 class="h2-subtitle">About Us</h2>
                            </div>
                            <h2 class="h2-title">Welcome To Our Fitness Gym</h2>
                        </div>
                        <p>Nam ut hendrerit leo. Aenean vel ipsum nunc. Curabitur in tellus vitae nisi aliquet dapibus non et erat. Pellentesque porta sapien non accumsan dignissim curabitur sagittis nulla sit amet dolor feugiat.</p>
                        <div class="points">
                            <ul>
                                <li>
                                    <div class="point-object"></div><p>Morbi sed massa scelerisque, porta dui vel, finibus nulla. Etiam accumsan, eros quis rhoncus interdum.</p>
                                </li>
                                <li>
                                    <div class="point-object"></div><p>Sed posuere purus eget pharetra commodo. Pellentesque consectetur quam in neque dignissim tincidunt.</p>
                                </li>
                                <li>
                                    <div class="point-object"></div><p>Nulla faucibus mi a lectus interdum tempor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </li>
                            </ul>
                        </div>
                        <a href="about-us.html" class="sec-btn">Explore More</a>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!--About Us End-->

    <!--Portfolio Start-->
    <div class="main-portfolio">
        <div class="container-fluid">
            <div class="row portfolio-slider">
                <div class="col-lg-4">
                    <div class="portfolio-box wow fadeInUp" data-wow-delay=".5s">
                        <img src="{{ asset('assets/frontend/images/portfolio-img1.jpg') }}" alt="Portfolio">
                        <div class="portfolio-content">
                            <span>Arriendo</span>
                            <a href="#"><h3 class="h3-title">Arriendo de Canchas</h3></a>
                        </div>
                    </div>
                </div>
             <div class="col-lg-4">
                    <div class="portfolio-box wow fadeInDown" data-wow-delay=".5s">
                        <img src="{{ asset('assets/frontend/images/escuela.png') }}" alt="Portfolio">
                        <div class="portfolio-content">
                            <span>Escuela mixta</span>
                            <a href="https://www.escuela.elcalccio.cl" target="_blank"><h3 class="h3-title">Escuela de Fútbol</h3></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="portfolio-box wow fadeInUp" data-wow-delay=".5s">
                        <img src="{{ asset('assets/frontend/images/academia.jpg') }}" alt="Portfolio">
                        <div class="portfolio-content">
                            <span>Entrenamiento para Adultos</span>
                            <a href="#"><h3 class="h3-title">Academia Calccio</h3></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="portfolio-box wow fadeInDown" data-wow-delay=".5s">
                        <img src="{{ asset('assets/frontend/images/liga.png') }}" alt="Portfolio">
                        <div class="portfolio-content">
                            <span>Versus Producciones</span>
                            <a href="https://www.versusproducciones.cl/" target="_blank"><h3 class="h3-title">Ligas F7</h3></a>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-4">
                    <div class="portfolio-box wow fadeInUp" data-wow-delay=".5s">
                        <img src="assets/images/portfolio-img5.jpg" alt="Portfolio">
                        <div class="portfolio-content">
                            <span>Weight Loss Program</span>
                            <a href="portfolio-detail.html"><h3 class="h3-title">Couple Fitness Workout</h3></a>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!--Portfolio End-->



    <!--Classes Start-->
    <section class="main-classes-two">
        <div class="sec-circle-one"></div>
        <div class="sec-circle-two"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="classes-title two">
                        <div class="subtitle">
                            <h2 class="h2-subtitle">Clases</h2>
                        </div>
                        <h2 class="h2-title">Nuestras Clases</h2>
                    </div>
                </div>
            </div>
            <div class="row class-slider" id="counter">
                <div class="col-lg-4">
                    <div class="class-box wow fadeInUp" data-wow-delay=".5s">
                        <div class="class-img">
                            <img src="{{ asset('assets/frontend/images/escuela2.png') }}" alt="Class">
                        </div>
                        <div class="class-box-contant">
                            <div class="class-box-title">
                                <div class="class-box-icon">
                                    <img src="{{ asset('assets/frontend/images/class-icon1.png') }}" alt="Icon">
                                </div>
                                <a href="#"><h3 class="h3-title">Escuela de Fútbol<br>Calccio F.C</h3></a>
                            </div>
                            <p>Entrenamiento orientados en la formación deportiva, social y personal, formamos personas de bien.</p>
                            <div class="class-full" id="progress_bar">
                                <div class="class-full-bar-box">
                                    <h3 class="h3-title">Clase Completa.</h3>
                                    <div class="class-full-bar-percent">
                                        <h3 class="h3-title counting-data" data-count="85">0</h3><span>%</span>
                                    </div>
                                    <div class="skill-bar class-bar" data-width="85%">
                                        <div class="skill-bar-inner class-bar-in"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="class-box wow fadeInDown" data-wow-delay=".5s">
                        <div class="class-img">
                            <img src="{{ asset('assets/frontend/images/academia2.jpg') }}" alt="Class">
                        </div>
                        <div class="class-box-contant">
                            <div class="class-box-title">
                                <div class="class-box-icon">
                                    <img src="{{ asset('assets/frontend/images/class-icon2.png') }}" alt="Icon">
                                </div>
                                <a href="#"><h3 class="h3-title">Academia Calccio<br>Entrenamiento para adultos</h3></a>
                            </div>
                            <p>Es la combinación perfecta entre dos disciplinas: fútbol y ejercicio funcional.</p>
                            <div class="class-full">
                                <div class="class-full-bar-box">
                                    <h3 class="h3-title">Clase Completa.</h3>
                                    <div class="class-full-bar-percent">
                                        <h3 class="h3-title counting-data" data-count="70">0</h3><span>%</span>
                                    </div>
                                    <div class="skill-bar class-bar" data-width="70%">
                                        <div class="skill-bar-inner class-bar-in"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="class-box wow fadeInUp" data-wow-delay=".5s">
                        <div class="class-img">
                            <img src="{{ asset('assets/frontend/images/liga2.png') }}" alt="Class">
                        </div>
                        <div class="class-box-contant">
                            <div class="class-box-title">
                                <div class="class-box-icon">
                                    <img src="{{ asset('assets/frontend/images/class-icon3.png') }}" alt="Icon">
                                </div>
                                <a href="#"><h3 class="h3-title">Ligas<br>Fútbol 7</h3></a>
                            </div>
                            <p>Diferentes modalidades, Senior, todo competidor, femenino e infantil, a cargo de la Productora VersusProducciones.</p>
                            <div class="class-full">
                                <div class="class-full-bar-box">
                                    <h3 class="h3-title">Clase Completa</h3>
                                    <div class="class-full-bar-percent">
                                        <h3 class="h3-title counting-data" data-count="90">0</h3><span>%</span>
                                    </div>
                                    <div class="skill-bar class-bar" data-width="90%">
                                        <div class="skill-bar-inner class-bar-in"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               <!--  <div class="col-lg-4">
                    <div class="class-box wow fadeInDown" data-wow-delay=".5s">
                        <div class="class-img">
                            <img src="assets/images/class-img4.jpg" alt="Class">
                        </div>
                        <div class="class-box-contant">
                            <div class="class-box-title">
                                <div class="class-box-icon">
                                    <img src="assets/images/class-icon4.png" alt="Icon">
                                </div>
                                <a href="class-detail.html"><h3 class="h3-title">Power Yoga<br>Classes</h3></a>
                            </div>
                            <p>Suspendisse nisi libero, cursus ac magna sit amet, fermentum imperdiet nisi.</p>
                            <div class="class-full">
                                <div class="class-full-bar-box">
                                    <h3 class="h3-title">Class Full</h3>
                                    <div class="class-full-bar-percent">
                                        <h3 class="h3-title counting-data" data-count="60">0</h3><span>%</span>
                                    </div>
                                    <div class="skill-bar class-bar" data-width="60%">
                                        <div class="skill-bar-inner class-bar-in"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <!--Classes End-->
     <!--Download App Start-->
    <section class="main-download-app">

        <div class="download-app-overlay-bg animate-this">
            <img src="{{ asset('assets/frontend/images/download-app-overlay-bg.png') }}" alt="Overlay">
        </div>
        <div class="container">

            <div class="row align-items-center">

                                 <!--Video Start-->

                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="video-box wow fadeInUp" data-wow-delay=".5s">
                                        <div class="video-img" style="background-image: url('{{ asset('assets/frontend/images/video.jpg') }}');">
                                            <div class="video-content">
                                                <h2 class="h2-title">Complejo el Calccio</h2>
                                                <div class="play-btn">
                                                    <a href="https://www.youtube.com/watch?v=E3vqucJ-dKQ" class="video-play-icon popup-youtube" title="Play Video"><span><i class="fa fa-play" aria-hidden="true"></i></span></a>
                                                </div>
                                                <a href="https://www.youtube.com/watch?v=E3vqucJ-dKQ" target="_blank" class="sec-btn-link">Ver Más Canal Youtube</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!--Video End-->

            </div>
        </div>
    </section>
    <!--Download App End-->


    <!--Schedule Start-->
    <section class="main-schedule">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="schedule-title">
                        <div class="subtitle">
                            <h2 class="h2-subtitle">Nuestros Horarios</h2>
                        </div>
                        <h2 class="h2-title">Horarios de Nuestras Clases</h2>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="main-schedule-box wow fadeInUp" data-wow-delay=".5s">
                        <div class="schedule-box">
                            <div class="schedule-time-box">
                                <ul>
                                    <li><img src="{{ asset('assets/frontend/images/clock-1.png') }}" alt="Clock"></li>
                                    <li><h3 class="h3-title">10:00 Pm</h3></li>
                                    <li><h3 class="h3-title">11:30 Pm</h3></li>
                                    <li><h3 class="h3-title">16:00 Pm</h3></li>
                                    <li><h3 class="h3-title">17:30 Pm</h3></li>
                                    <li><h3 class="h3-title">18:00 Pm</h3></li>
                                    <li><h3 class="h3-title">19:00 Pm</h3></li>
                                    <li><h3 class="h3-title">20:00 Pm</h3></li>
                                </ul>
                            </div>
                            <div class="schedule-class-box">
                                <ul>
                                    <li><h3 class="h3-title">Lunes</h3></li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span></span>
                                        </div>
                                    </li>
                                      <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span></span>
                                        </div>
                                    </li>
                                      <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title">Entrenamiento de Arqueros</h3>
                                       <span>Calccio F.C</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title">Academia Calccio Entrenamiento Adultos</h3>
                                        <span>Academia Calccio</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="schedule-class-box">
                                <ul>
                                    <li><h3 class="h3-title">Martes</h3></li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"> </h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"> </h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"> </h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                    <li></li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"> </h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="schedule-class-box">
                                <ul>
                                    <li><h3 class="h3-title">Miercoles</h3></li>
                                    <li></li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"> </h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"> </h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"> </h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title">Entrenamiento de Arqueros</h3>
                                       <span>Calccio F.C</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title">Academia Calccio Entrenamiento Adultos</h3>
                                        <span>Academia Calccio</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"> </h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="schedule-class-box">
                                <ul>
                                    <li><h3 class="h3-title">Jueves</h3></li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"> </h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"> </h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                    <li></li>

                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title">Escuela Calccio de 5 a 10 años</h3>
                                        <span>Calccio F.C</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title">Escuela Calccio de 11 a 16 años</h3>
                                        <span>Calccio F.C</span>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="schedule-class-box">
                                <ul>
                                    <li><h3 class="h3-title">Viernes</h3></li>
                                     <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"> </h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"> </h3>
                                        <span> </span>
                                        </div>
                                    </li>
                                   <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title">Escuela Calccio de 5 a 12 años</h3>
                                        <span>Calccio F.C</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title">Escuela Calccio de 13 a 16 años</h3>
                                          <span>Calccio F.C</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title">Entrenamiento de Arqueros</h3>
                                        <span>Calccio F.C</span>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title">Academia Calccio Entrenamiento Adultos</h3>
                                        <span>Academia Calccio</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                           <div class="schedule-class-box">
                                <ul>
                                    <li><h3 class="h3-title">Sabado</h3></li>
                                      <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title">Escuela Calccio de 5 a 12 años</h3>
                                        <span>Calccio F.C</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title">Escuela Calccio de 13 a 16 años</h3>
                                        <span>Calccio F.C</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span></span>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="schedule-class-text">
                                        <h3 class="h3-title"></h3>
                                        <span></span>
                                        </div>
                                    </li>
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Schedule End-->



    <!--Team Start-->
    <section class="main-team-two">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="team-title two">
                        <div class="subtitle">
                            <h2 class="h2-subtitle">Nuestros Profesionales</h2>
                        </div>
                        <h2 class="h2-title">Profesores Del Calccio</h2>
                    </div>
                </div>
            </div>
            <div class="row team-slider">
                <div class="col-lg-3">
                    <div class="team-box wow fadeInUp" data-wow-delay=".5s">
                        <div class="team-img-box team-border-two">
                            <div class="team-img">
                                <img src="{{ asset('assets/frontend/images/luis.jpg') }}" alt="Trainer">
                            </div>
                        </div>
                        <div class="team-content">
                            <a href="team-detail.html"><h3 class="h3-title">Luis Ojeda</h3></a>
                            <span>Jefe Técnico - Prof. Ed. Física</span>
                            <div class="team-social">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="team-box wow fadeInDown" data-wow-delay=".5s">
                        <div class="team-img-box team-border-two">
                            <div class="team-img">
                                <img src="{{ asset('assets/frontend/images/enzo.jpg') }}" alt="Trainer">
                            </div>
                        </div>
                        <div class="team-content">
                            <a href="team-detail.html"><h3 class="h3-title">Enzo Vergara</h3></a>
                            <span>Prepadador Físico - Est. Ped. Ed.Física</span>
                            <div class="team-social">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="team-box wow fadeInUp" data-wow-delay=".5s">
                        <div class="team-img-box team-border-two">
                            <div class="team-img">
                                <img src="{{ asset('assets/frontend/images/dani.jpg') }}" alt="Trainer">
                            </div>
                        </div>
                        <div class="team-content">
                            <a href="team-detail.html"><h3 class="h3-title">Daniela Asencio</h3></a>
                            <span>Profesora de Ed. Física</span>
                            <div class="team-social">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="team-box wow fadeInDown" data-wow-delay=".5s">
                        <div class="team-img-box team-border-two">
                            <div class="team-img">
                                <img src="{{ asset('assets/frontend/images/tenorio.jpg') }}" alt="Trainer">
                            </div>
                        </div>
                        <div class="team-content">
                            <a href="team-detail.html"><h3 class="h3-title">Victor Tenorio</h3></a>
                            <span>Prepadador Físico - Est. Ped. Ed.Física</span>
                            <div class="team-social">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="team-box wow fadeInUp" data-wow-delay=".5s">
                        <div class="team-img-box team-border-two">
                            <div class="team-img">
                                <img src="{{ asset('assets/frontend/images/torres.jpg') }}" alt="Trainer">
                            </div>
                        </div>
                        <div class="team-content">
                            <a href="team-detail.html"><h3 class="h3-title">Victor Torres</h3></a>
                            <span>Técnico Deportivo</span>
                            <div class="team-social">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Team End-->

    <!--Pricing Start-->
    <section class="main-pricing-two">
        <div class="sec-circle-one"></div>
        <div class="sec-circle-two"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pricing-title">
                        <div class="subtitle">
                            <h2 class="h2-subtitle">Precios</h2>
                        </div>
                        <h2 class="h2-title">Nuestros Planes</h2>
                    </div>
                </div>
            </div>
            <div class="row pricing-slider">
                <div class="col-lg-4">
                    <div class="pricing-box wow fadeInUp" data-wow-delay=".5s">
                        <div class="pricing-title-box pricing-one">
                            <h3 class="h3-title">Arriendo de Canchas</h3>
                            <h2 class="h2-title">$28.000<span>/Hora</span></h2>
                        </div>
                        <div class="pricing-content-box">
                            <div class="pricing-content">
                                <div class="pricing-point">
                                    <ul>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>Canchas de Fútbol 7</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>Canchas Oficiales</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>Solicita tu hora llamando al + 56 9 7748 0252</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>Ven a jugar a nuestras canchas</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>excelente momento jugando con tus amigos o amigas.</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                           <!--  <a href="contact-us.html" class="sec-btn">Join Now</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="pricing-box wow fadeInDown" data-wow-delay=".5s">
                        <div class="pricing-title-box pricing-two">
                            <h3 class="h3-title">Escuela Calccio F.C</h3>
                            <h2 class="h2-title">$25.000<span>/Mensual</span></h2>
                        </div>
                        <div class="pricing-content-box">
                            <div class="pricing-content">
                                <div class="pricing-point">
                                    <ul>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>Fútbol Formativo</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>Proporcionar un espacio para la recreación</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>Planes de entrenamiento orientados en la formación deportiva</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>A través del fútbol formamos personas</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>Buenos deportistas</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                           <!--  <a href="contact-us.html" class="sec-btn">Join Now</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="pricing-box wow fadeInUp" data-wow-delay=".5s">
                        <div class="pricing-title-box pricing-three">
                            <h3 class="h3-title">Academia Calccio</h3>
                            <h2 class="h2-title">$30.000<span>/Mensual</span></h2>
                        </div>
                        <div class="pricing-content-box">
                            <div class="pricing-content">
                                <div class="pricing-point">
                                    <ul>
                                         <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>Entrenamiento Mixto para Adultos.</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>Fútbol y ejercicio funcional</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>objetivo mejorar tu técnica y aumentar tu acondicionamiento físico</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>Es una actividad MIXTA que dura 60' apta para iniciales y avanzados</p>
                                        </li>

                                        <li>
                                            <img src="{{ asset('assets/frontend/images/check.png') }}" alt="Check">
                                            <p>Profesionales del área del Deporte</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                          <!--   <a href="contact-us.html" class="sec-btn">Join Now</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Pricing End-->

    <!--Appointment Start-->
   <!--  <section class="main-appointment-two">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="statics-contant wow fadeInLeft" data-wow-delay=".5s">
                        <div class="statics-title">
                            <div class="subtitle">
                                <h2 class="h2-subtitle">Our Statics</h2>
                            </div>
                            <h2 class="h2-title">We Are Best In Our Classe</h2>
                        </div>
                        <p>Suspendisse blandit ornare eros vel vehicula. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed ullamcorper ex eu lectus viverra efficitur.</p>
                        <div class="skill-content">
                            <div class="skill-progress">
                                <div class="skill-bar-box">
                                    <h3 class="h3-title">Client Satisfaction</h3>
                                    <div class="skill-bar-percent">
                                        <h3 class="h3-title counting-data" data-count="90">0</h3><span>%</span>
                                    </div>
                                    <div class="skill-bar" data-width="90%">
                                        <div class="skill-bar-inner"></div>
                                    </div>
                                </div>
                                <div class="skill-bar-box mb-0">
                                    <h3 class="h3-title">Support Customer</h3>
                                    <div class="skill-bar-percent">
                                        <h3 class="h3-title counting-data" data-count="80">0</h3><span>%</span>
                                    </div>
                                    <div class="skill-bar" data-width="80%">
                                        <div class="skill-bar-inner"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="appointment-bg wow fadeInRight" data-wow-delay=".5s">
                        <div class="appointment-title">
                            <h2 class="h2-title">Get Appointment</h2>
                            <div class="line"></div>
                        </div>
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-box">
                                        <input type="text" name="Full Name" class="form-input" placeholder="Full Name" required="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-box">
                                        <input type="email" name="EmailAddress" class="form-input" placeholder="Email Address" required="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-box">
                                        <input type="text" name="Phone No" class="form-input" placeholder="Phone No." required="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-box">
                                        <textarea class="form-input" placeholder="Message..."></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-box mb-0">
                                        <button type="submit" class="sec-btn"><span>Submit Now</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!--Appointment End-->

     <!--Counter Start-->
     <section class="main-counter">
        <div class="container">
            <div class="row counter-bg wow fadeInUp" data-wow-delay=".5s">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-box">
                        <div class="counter-content">
                            <h2 class="h2-title counting-data" data-count="435">435</h2>
                            <div class="counter-text">
                                <img src="{{ asset('assets/frontend/images/happy-client.png') }}" alt="Happy Client">
                                <span>Clientes Felices</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-box">
                        <div class="counter-content">
                            <h2 class="h2-title counting-data" data-count="137">137</h2>
                            <div class="counter-text">
                                <img src="{{ asset('assets/frontend/images/total-clients.png') }}" alt="Total Clients">
                                <span>Alumnos Entrenando</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-box">
                        <div class="counter-content">
                            <h2 class="h2-title counting-data" data-count="10">10</h2>
                            <div class="counter-text">
                                <img src="{{ asset('assets/frontend/images/gym-equipment.png') }}" alt="Gym Equipment">
                                <span>Equipamiento Gym</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-box">
                        <div class="counter-content">
                            <h2 class="h2-title counting-data" data-count="15">15</h2>
                            <div class="counter-text">
                                <img src="{{ asset('assets/frontend/images/cup-of-coffee.png') }}" alt="Cup Of Coffee">
                                <span>Ligas F7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Counter End-->

    <!--Testimonial Start-->
    <section class="main-testimonial-two">
        <div class="sec-circle-one"></div>
        <div class="sec-circle-two"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="testimonial-title">
                        <div class="subtitle">
                            <h2 class="h2-subtitle">Clientes</h2>
                        </div>
                        <h2 class="h2-title">Lo que opinan nuestros clientes.</h2>
                    </div>
                </div>
            </div>
            <div class="row testimonial-slider">
                <div class="col-lg-4">
                    <div class="testimonial-box wow fadeInUp" data-wow-delay=".5s">
                        <div class="client-box">
                            <div class="client-img">
                                <img src="{{ asset('assets/frontend/images/franco.jpg') }}" class="rounded-circle" alt="Client">
                            </div>
                            <div class="client-name">
                                <h3 class="h3-title">Franco Martí</h3>
                                <span>Cliente</span>
                            </div>
                        </div>
                        <p>Llevo casi 2 años asistiendo al Calccio y la calidad de las canchas como de las personas, además del progreso constante para mejorar la experiencia en sus instalaciones, hacen que se conviertan para mi en las mejores canchas de la comuna.</p>
                        <div class="review-star">
                            <ul>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-box wow fadeInDown" data-wow-delay=".5s">
                        <div class="client-box">
                            <div class="client-img">
                                <img src="{{ asset('assets/frontend/images/lilian.jpg') }}" class="rounded-circle" alt="Client">
                            </div>
                            <div class="client-name">
                                <h3 class="h3-title">Lilian Hidalgo</h3>
                                 <span>Cliente</span>
                            </div>
                        </div>
                        <p>Phasellus accumsan pretium ligula non rhoncus. Aliquam porttitor, velit congue ultricies elementum, tortor ipsum.</p>
                        <div class="review-star">
                            <ul>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-box wow fadeInUp" data-wow-delay=".5s">
                        <div class="client-box">
                            <div class="client-img">
                                <img src="{{ asset('assets/frontend/images/jorge.jpg') }}" class="rounded-circle" alt="Client">
                            </div>
                            <div class="client-name">
                                <h3 class="h3-title">Jorge Pavez</h3>
                                 <span>Cliente</span>
                            </div>
                        </div>
                        <p>Phasellus accumsan pretium ligula non rhoncus. Aliquam porttitor, velit congue ultricies elementum, tortor ipsum.</p>
                        <div class="review-star">
                            <ul>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-box wow fadeInDown" data-wow-delay=".5s">
                        <div class="client-box">
                            <div class="client-img">
                                <img src="{{ asset('assets/frontend/images/client4.jpg') }}" class="rounded-circle" alt="Client">
                            </div>
                            <div class="client-name">
                                <h3 class="h3-title">Juan Aburto</h3>
                                 <span>Cliente</span>
                            </div>
                        </div>
                        <p>Phasellus accumsan pretium ligula non rhoncus. Aliquam porttitor, velit congue ultricies elementum, tortor ipsum.</p>
                        <div class="review-star">
                            <ul>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Testimonial End-->

    @if ($articles->count())
        <!--Blog Start-->
        <section class="main-blog">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="blog-title">
                            <div class="subtitle">
                                <h2 class="h2-subtitle">Nuestras Noticias</h2>
                            </div>
                            <h2 class="h2-title">Noticias Complejo El Calccio</h2>
                        </div>
                    </div>
                </div>
                <div class="row blog-slider">
                    @foreach ($articles as $article)
                        <div class="col-lg-4">
                            <div class="blog-box wow fadeInUp" data-wow-delay=".5s">
                                <div class="blog-img">
                                    <img style="height: 250px;" src="{{ asset($article->image) }}" alt="Fotografia El Calccio: {{ $article->title }}">
                                    <div class="blog-date">
                                        <span>{{ $article->getTranslatedDate()  }}</span>
                                    </div>
                                </div>
                                <div class="blog-content">
                                    <a href="{{ route('frontend.articles.show', $article->slug) }}"><h3 class="h3-title">{{ $article->title }}</h3></a>
                                    <p>{{ Str::limit(strip_tags($article->content), 200) }}</p>
                                    <a href="{{ route('frontend.articles.show', $article->slug) }}" class="sec-btn-link">Leer mas...</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!--Blog End-->
    @endif
@endsection
