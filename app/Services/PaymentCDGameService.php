<?php

namespace App\Services;

use App\Models\PaymentCDGame;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PaymentCDGameService
{
    public function getAll($limit, $page, $keyword){
        $data = PaymentCDGame::with(['user', 'cdGame'])
            ->whereIn('user_id', function (Builder $q) use ($keyword) {
                $q->select('id')
                    ->from('users')
                    ->where('full_name', 'like',"%{$keyword}%");
            })
            ->offset(($page - 1) * 10)
            ->paginate($limit);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['user'] = $data[$i]->user;
            $data[$i]['cd_game'] = $data[$i]->cdGame;
            unset($data[$i]['cd_games_id']);
            unset($data[$i]['user_id']);
        }

        return $data;
    }

    public function getDetail($id){
        $data = PaymentCDGame::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('payment_cd_games')->delete($id);

        return $result;
    }
}
