<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontProductController extends Controller
{
    public function index()
    {
        $products =  Product::with('category')->latest()->paginate(8);

        return $products;
    }
}
