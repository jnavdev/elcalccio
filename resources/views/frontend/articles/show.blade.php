@extends('frontend.layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/gijgo@1.9.13/css/gijgo.min.css">
@endsection

@section('content')
    <!--Banner Start-->
    <section class="main-inner-banner jarallax" data-jarallax data-speed="0.2" data-imgPosition="20% 0%"
        style="background-image: url({{ asset('assets/frontend/images/fondo-calendario-reservas.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-in-title">
                        <h1 class="h1-title">{{ $article->title }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Banner End-->

    <!--Blog Detail Start-->
    <section class="main-blog-detail">
        <div class="container">
            <div class="row">
                <!--Blog Detail info Start-->
                <div class="col-lg-8">
                    <div class="blog-detail-info-content">
                        <div class="blog-detail-main-img">
                            <div class="blog-img wow fadeInUp" data-wow-delay=".5s">
                                <img src="{{ asset($article->image) }}" alt="Fotografia El Calccio: {{ $article->title }}">
                                <div class="blog-date">
                                    <span>{{ $article->getTranslatedDate() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="blog-big-main-title">
                            <h2 class="h2-title">{{ $article->title }}</h2>
                        </div>

                        {!! $article->content !!}

                        <div class="blog-object-box">
                            <div class="tag-social">
                                <div class="blog-social">
                                    <ul>
                                        <li><a href="javascript:void(0);"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li><a href="javascript:void(0);"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                        <li><a href="javascript:void(0);"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li><a href="javascript:void(0);"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Blog Detail info End-->
                <!--Sidebar Start-->
                <div class="col-lg-4">
                    @if ($recentArticles->count())
                        <div class="recent-post">
                            <h3 class="h3-title">Ultimas noticias</h3>
                            <div class="line"></div>
                            <ul>
                                @foreach ($recentArticles as $article)
                                    <li>
                                        <div class="recent-post-img" style="width: 90%;">
                                            <img src="{{ asset($article->image) }}" alt="Fotografia El Calccio: {{ $article->title }}">
                                        </div>
                                        <div class="recent-post-text">
                                            <a href="{{ route('frontend.articles.show', $article->slug) }}">{{ $article->title }}</a>
                                            <a href="javascript:void(0);">{{ $article->getTranslatedDate()  }}</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <!--Sidebar Start-->
            </div>
        </div>
    </section>
    <!--Blog Detail End-->
@endsection
