<?php

namespace App\Services;

use App\Models\PaymentAccessory;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PaymentAccessoryService
{
    public function getAll($limit, $page, $keyword){
        $data = PaymentAccessory::with(['user', 'accessory'])
            ->whereIn('user_id', function (Builder $q) use ($keyword) {
                $q->select('id')
                    ->from('users')
                    ->where('full_name', 'like',"%{$keyword}%");
            })
            ->offset(($page - 1) * 10)
            ->paginate($limit);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['user'] = $data[$i]->user;
            $data[$i]['accessory'] = $data[$i]->accessory;
            unset($data[$i]['accessory_id']);
            unset($data[$i]['user_id']);
        }

        return $data;
    }

    public function getDetail($id){
        $data = PaymentAccessory::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('payment_accessory')->delete($id);

        return $result;
    }
}
