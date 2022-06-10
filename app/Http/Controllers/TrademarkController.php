<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrademarkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function index() {

    }
}
