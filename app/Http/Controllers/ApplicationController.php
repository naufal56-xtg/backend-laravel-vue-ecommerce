<?php

namespace App\Http\Controllers;


class ApplicationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return view('layouts.app');
    }
}
