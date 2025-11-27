<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $jsonPath = public_path('articles.json');
        $articles = json_decode(file_get_contents($jsonPath), true);

        return view('home', ['articles' => $articles]);
    }

    public function gallery($index)
    {
        $jsonPath = public_path('articles.json');
        $articles = json_decode(file_get_contents($jsonPath), true);

        if (isset($articles[$index])) {
            return view('gallery', ['article' => $articles[$index]]);
        }

        abort(404);
    }
}
