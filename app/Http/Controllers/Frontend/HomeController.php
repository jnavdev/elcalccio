<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Article;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function loginView()
    {
        return view('frontend.auth.login');
    }

    public function index()
    {
        $articles = Article::orderBy('id', 'DESC')->take(3)->get();

        return view('frontend.home', compact('articles'));
    }
}
