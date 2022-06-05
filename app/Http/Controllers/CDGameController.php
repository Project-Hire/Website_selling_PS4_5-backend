<?php

namespace App\Http\Controllers;

use App\Services\CDGameService;
use Illuminate\Http\Request;

class CDGameController extends Controller
{
    private $cdGameService;
    public function __construct(CDGameService $cdGameService) {
        $this->middleware('auth:api', ['except' => ['index', 'detail']]);
        $this->cdGameService = $cdGameService;
    }



}
