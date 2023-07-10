<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()->with(
            'users'
        )->when(request('query'), function ($query, $searchQuery) {
            $query->where('no_pesanan', 'like', "%{$searchQuery}%");
        })->latest()->paginate(0);



        return $orders;
    }

    public function store()
    {
        $orders = Order::where('id', Auth::user()->id)->first();

        $orders->create([
            'no_pesanan' => 'INV-' . time(),
            'qty' => request('qty'),
            'total' => request('total'),
            'status_pesanan' => 1,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json(['msg' => 'Pesanan Berhasil Dibuat']);
    }
}
