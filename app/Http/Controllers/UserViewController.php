<?php

namespace App\Http\Controllers;

class UserViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewList() {
        return view('users.view-list');
    }
}
