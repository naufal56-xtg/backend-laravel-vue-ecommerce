<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class FrontWishlistController extends Controller
{
    public function index()
    {

        $wishlists =  Wishlist::latest()->get();

        return $wishlists;
    }
}
