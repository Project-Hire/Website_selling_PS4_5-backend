<?php

namespace App\Http\Controllers;

use App\Services\GameConsoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class GameConsoleController extends Controller
{
    private $gameConsoleService;
    public function __construct(GameConsoleService $gameConsoleService) {
        $this->middleware('auth:api', ['except' => ['index', 'detail']]);
        $this->gameConsoleService = $gameConsoleService;
    }

    public function index(Request $request) {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;

            $result = $this->gameConsoleService->getAll($limit, $page, $keyword);

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
            $price = $request->price;
            $description = $request->description;
            $image = $request->image;
            $created_at = $request->created_at;
            $updated_at = $request->updated_at;
            $viewer = 0;

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'trademark_id' => 'required',
                'description' => 'required',
                'quantity' => 'required',
                'discount' => 'required',
                'price' => 'required',
                'image' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }else{
                $data = DB::table('game_console')->insert([
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
                        'message' => "Add game console successful"
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
            $result = $this->gameConsoleService->getDetail($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have game console details'
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
            $result = $this->gameConsoleService->delete($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Delete successful'
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have any game console'
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

            $result = DB::update('update game_console set name = ?, description = ?, trademark_id= ?, quantity= ?, discount= ?, price= ?, image= ? where id = ?', [$name, $description, $trademark_id, $quantity, $discount, $price,$image, $id]);

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
