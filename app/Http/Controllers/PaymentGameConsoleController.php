<?php

namespace App\Http\Controllers;

use App\Services\PaymentGameConsoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class PaymentGameConsoleController extends Controller
{
    private $paymentGameConsoleService;
    public function __construct(PaymentGameConsoleService $paymentGameConsoleService) {
        $this->middleware('auth:api', ['except' => ['index', 'detail']]);
        $this->paymentGameConsoleService = $paymentGameConsoleService;
    }

    public function index(Request $request) {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;

            $result = $this->paymentGameConsoleService->getAll($limit, $page, $keyword);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have payment accessory'
                ], 404);
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function store(Request $request) {
        try {
            $game_console_id = $request->game_console_id;
            $user_id = $request->user_id;
            $email = $request->email;
            $money = $request->money;
            $created_at = $request->created_at;
            $updated_at = $request->updated_at;

            $validator = Validator::make($request->all(), [
                'game_console_id' => 'required',
                'user_id' => 'required',
                'quantity' => 'required',
                'email' => 'required',
                'money' => 'required',
            ]);

            if($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            } else{
                $data = DB::table('payment_gameconsole')->insert([
                    'game_console_id' => $game_console_id,
                    'email' => $email,
                    'user_id' => $user_id,
                    'money' => $money,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ]);

                if($data){
                    return response()->json([
                        'status' => 1,
                        'message' => "You order successfully"
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "You order fail"
                    ], 404);
                }
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function detail($id){
        try{
            $result = $this->paymentGameConsoleService->getDetail($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have payment accessory details'
                ], 404);
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function delete($id){
        try {
            $result = $this->paymentGameConsoleService->delete($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Delete successful'
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have payment'
                ], 404);
            }
        }catch (\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }
}
