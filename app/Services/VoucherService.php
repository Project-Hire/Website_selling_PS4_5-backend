<?php

namespace App\Services;

use App\Models\Voucher;
use Illuminate\Support\Facades\DB;

class VoucherService
{
    public function getVoucher($keyword) {
        $result = DB::table('vouchers')->where('name', 'LIKE', $keyword)->get();

        return $result;
    }

    public function get($limit, $page, $keyword) {
        $data = DB::table('vouchers')
            ->where('name', 'LIKE', "%{$keyword}%")
            ->offset(($page - 1) * 10)
            ->paginate($limit);

        return $data;
    }
}
