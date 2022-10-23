<?php

namespace App\Http\Controllers;

use App\Services\CDGameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class CDGameController extends Controller
{
    private $cdGameService;
    public function __construct(CDGameService $cdGameService) {
        $this->middleware('auth:api', ['except' => ['index', 'detail', 'store']]);
        $this->cdGameService = $cdGameService;
    }

    public function index(Request $request) {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;

            $result = $this->cdGameService->getAll($limit, $page, $keyword);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have showtime'
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
            $description = $request->description;
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
                'description' => 'required',
                'price' => 'required',
                'image' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }else{
                $data = DB::table('cd_games')->insert([
                    'name' => $name,
                    'trademark_id' => $trademark_id,
                    'quantity' => $quantity,
                    'discount' => $discount,
                    'description' => $description,
                    'price' => $price,
                    'image' => $image,
                    'viewer' => $viewer,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ]);

                if($data){
                    return response()->json([
                        'status' => 1,
                        'message' => "Add CD Game Successful"
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "Add CD Game Fail"
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
            $result = $this->cdGameService->getDetail($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have cd game details'
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
            $result = $this->cdGameService->delete($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Delete successful'
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have cd game'
                ], 404);
            }
        }catch (\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function update(Request $request){
        try {
            $id = $request->id;
            $name = $request->name;
            $trademark_id = $request->trademark_id;
            $quantity = $request->quantity;
            $description = $request->description;
            $discount = $request->discount;
            $price = $request->price;
            $image = $request->image;

            $result = DB::update('update cd_games set name = ?,description =?, trademark_id= ?, quantity= ?, discount= ?, price= ?, image= ? where id = ?', [$name, $description, $trademark_id, $quantity, $discount, $price,$image, $id]);

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Update successful'
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'Update fail'
                ], 404);
            }
        }catch(\Exception $err) {
            response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }
}
