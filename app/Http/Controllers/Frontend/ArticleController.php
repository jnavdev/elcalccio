<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::title($request->get('title'))->orderBy('id', 'DESC')->paginate(6);
        $recentArticles = Article::orderBy('id', 'DESC')->take(4)->get();

        return view('frontend.articles.index', compact('articles', 'recentArticles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->first();
        $recentArticles = Article::orderBy('id', 'DESC')->take(4)->get();

        return view('frontend.articles.show', compact('article', 'recentArticles'));
    }
}
