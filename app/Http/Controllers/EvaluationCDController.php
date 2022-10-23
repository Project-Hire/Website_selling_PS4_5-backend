<?php

namespace App\Http\Controllers;

use App\Services\EvaluationCDService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class EvaluationCDController extends Controller
{
    private $evaluationCdService;
    public function __construct(EvaluationCDService $evaluationCdService) {
        $this->middleware('auth:api', ['except' => ['index', 'detail']]);
        $this->evaluationCdService = $evaluationCdService;
    }

    public function index(Request $request) {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;

            $result = $this->evaluationCdService->getAll($limit, $page, $keyword);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have evaluation cd'
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
            $name = $request->name;
            $trademark_id = $request->trademark_id;
            $quantity = $request->quantity;
            $discount = $request->discount;
            $price = $request->price;
            $image = $request->image;
            $created_at = $request->created_at;
            $updated_at = $request->updated_at;
            $viewer = 0;

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'trademark_id' => 'required',
                'quantity' => 'required',
                'discount' => 'required',
                'price' => 'required',
                'image' => 'required',
            ]);

            if($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            } else{
                $data = DB::table('accessory')->insert([
                    'name' => $name,
                    'trademark_id' => $trademark_id,
                    'quantity' => $quantity,
                    'discount' => $discount,
                    'price' => $price,
                    'image' => $image,
                    'viewer' => $viewer,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ]);

                if($data){
                    return response()->json([
                        'status' => 1,
                        'message' => "Your comment have been applied"
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "Add Accessory Fail"
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
            $result = $this->evaluationAccessoryService->getDetail($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have accessory details'
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
            $result = $this->evaluationAccessoryService->delete($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Delete successful'
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have accessory'
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
