<?php

namespace App\Services;

use App\Models\Gift_card;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class GiftCardService
{
    public function getAll($limit, $page, $keyword){
        $data = Gift_card::with(['trademark'])
            ->whereIn('trademark_id', function (Builder $q) use ($keyword) {
                $q->select('id')
                    ->from('trademarks')
                    ->where('name', 'like',"%{$keyword}%");
            })
            ->offset(($page - 1) * 10)
            ->paginate($limit);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['trademark'] = $data[$i]->trademark;
            unset($data[$i]['trademark_id']);
        }
        return $data;
    }

    public function getDetail($id){
        $data = Gift_card::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('gift_card')->delete($id);

        return $result;
    }
}
