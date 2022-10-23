<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Database\Query\Builder;

class CartService
{
    public function getVoucher($keyword) {
        $data = Cart::with(['trademark'])
            ->whereIn('trademark_id', function (Builder $q) use ($keyword) {
                $q->select('id')
                    ->from('trademarks')
                    ->where('name', 'like',"%{$keyword}%");
            })
            ->where('user_id', 'LIKE', "%{$keyword}%")
            ->get();

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['user'] = $data[$i]->user;
            $data[$i]['cd_game'] = $data[$i]->cdGame;
            unset($data[$i]['cd_game_id']);
            unset($data[$i]['user_id']);
        }

        return $data;
    }
}
