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
                        <h1 class="h1-title">Noticias</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Banner End-->

    <!--Blog List Start-->
    <section class="main-blog-list">
        <div class="container">
            <div class="row">
                <!--Blog Start-->
                <div class="col-lg-8">
                    <div class="blog-list-big-blog">
                        @if ($articles->count())
                            @foreach ($articles as $article)
                                <div class="blog-box wow fadeInUp" data-wow-delay=".5s">
                                    <div class="blog-img">
                                        <img src="{{ asset($article->image) }}" alt="Fotografia El Calccio: {{ $article->title }}">
                                        <div class="blog-date">
                                            <span>{{ $article->getTranslatedDate() }}</span>
                                        </div>
                                    </div>
                                    <div class="blog-content">
                                        <a href="{{ route('frontend.articles.show', $article->slug) }}"><h3 class="h3-title">{{ $article->title }}</h3></a>
                                        <p>{{ Str::limit(strip_tags($article->content), 300) }}</p>
                                        <a href="{{ route('frontend.articles.show', $article->slug) }}" class="sec-btn-link">Leer mas...</a>
                                    </div>
                                </div>
                            @endforeach

                            {{ $articles->withQueryString()->links('vendor.pagination.custom') }}
                        @else
                            <h4>No hay registros</h4>
                        @endif
                    </div>
                </div>
                <!--Blog End-->
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
    <!--Blog List End-->
@endsection
