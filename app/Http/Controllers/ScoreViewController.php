<?php

namespace App\Http\Controllers;

class ScoreViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view() {
        return view('score.view');
    }
}
