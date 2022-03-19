<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use stdClass;

class ProductViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewList() {
        return view('products.view-list');
    }
}
