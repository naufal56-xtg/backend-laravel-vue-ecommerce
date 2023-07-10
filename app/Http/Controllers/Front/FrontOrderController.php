<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class FrontOrderController extends Controller
{
    public function index()
    {
        $orders =  Order::latest()->get();

        return $orders;
    }
}
