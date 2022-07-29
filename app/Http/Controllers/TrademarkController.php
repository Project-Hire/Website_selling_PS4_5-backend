<?php

namespace App\Http\Controllers;

use App\Services\TrademarkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class TrademarkController extends Controller
{
    private $trademarkService;
    public function __construct(TrademarkService $trademarkService) {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->trademarkService = $trademarkService;
    }

    public function index(Request $request) {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;
            $result = $this->trademarkService->getAll($limit, $page, $keyword);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have this trademark'
                ], 404);
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function detail($id) {
        try {
            $result = $this->trademarkService->getDetail($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont this advertisement'
                ], 404);
            }
        } catch (\Exception $err) {
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function store(Request $request) {
        try {
            $name = $request->name;
            $image = $request->image;
            $created_at = $request->created_at;

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'image' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }else{
                $data = DB::table('trademarks')->insert([
                    'name' => $name,
                    'image' => $image,
                    'created_at' => $created_at,
                    'updated_at' => $created_at
                ]);

                if($data) {
                    return response()->json([
                        'status' => 1,
                        'message' => "Add advertisement successful"
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "Add advertisement fail"
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

    public function delete($id) {
        try {
            $result = $this->trademarkService->delete($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Delete successful'
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have trademark details'
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
            $image = $request->image;
            $updated_at = $request->updated_at;

            $result = DB::update('update trademarks set image = ?, name = ?, updated_at = ?  where id = ?', [$image, $name, $updated_at, $id]);

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Update successful'
                ], 201);
            } else{
                return response()->json([
                    'status' => 0,
                    'message' => 'Update fail'
                ], 404);
            }
        } catch(\Exception $exception){
            response()->json([
                'err' => $exception,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }
}
