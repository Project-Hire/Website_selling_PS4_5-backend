<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private $cartService;
    public function __construct(CartService $cartService) {
        $this->middleware('auth:api', ['except' => ['index', 'detail']]);
        $this->cartService = $cartService;
    }

    public function cartByUserId(Request $request) {
        $user_id = $request->user_id;

        $result = DB::table('');
    }
}
