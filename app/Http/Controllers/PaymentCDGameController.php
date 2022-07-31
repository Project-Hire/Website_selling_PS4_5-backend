<?php

namespace App\Http\Controllers;

use App\Services\PaymentCDGameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class PaymentCDGameController extends Controller
{
    private $paymentCDGameService;
    public function __construct(PaymentCDGameService $paymentCDGameService) {
        $this->middleware('auth:api', ['except' => ['index', 'detail']]);
        $this->paymentCDGameService = $paymentCDGameService;
    }

    public function index(Request $request) {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;

            $result = $this->paymentCDGameService->getAll($limit, $page, $keyword);

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
            $cd_games_id = $request->cd_games_id;
            $user_id = $request->user_id;
            $email = $request->email;
            $money = $request->money;
            $created_at = $request->created_at;
            $updated_at = $request->updated_at;

            $validator = Validator::make($request->all(), [
                'cd_games_id' => 'required',
                'user_id' => 'required',
                'email' => 'required',
                'money' => 'required',
            ]);

            if($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            } else{
                $data = DB::table('payment_cd_games')->insert([
                    'cd_games_id' => $cd_games_id,
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
            $result = $this->paymentCDGameService->getDetail($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have payment cd game details'
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
            $result = $this->paymentCDGameService->delete($id);

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
