<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSeosController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function find(Request $request)
    {
    	
    }

    public function update()
    {

    }
}
