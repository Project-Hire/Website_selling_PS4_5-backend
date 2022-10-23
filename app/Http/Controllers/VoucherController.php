<?php

namespace App\Http\Controllers;

use App\Services\VoucherService;
use Illuminate\Http\Request;
use Validator;

class VoucherController extends Controller
{
    private $voucherService;
    public function __construct(VoucherService $voucherService) {
        $this->middleware('auth:api', ['except' => ['index', 'getVoucherDiscount']]);
        $this->voucherService = $voucherService;
    }

    public function index(Request $request) {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;
            $result = $this->voucherService->get($limit, $page, $keyword);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have this advertisement'
                ], 404);
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function getVoucherDiscount(Request $request) {
        try {
            $voucher = $request->voucher;

            $result = $this->voucherService->getVoucher($voucher);

            if($voucher != '') {
                return response()->json([
                    'status' => 1,
                    'data' => $result,
                    'message' => "Congratulations, You have discount voucher"
                ], 201);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => "Invalid voucher!"
                ], 201);
            }

        } catch (\Exception $err) {
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }
}
