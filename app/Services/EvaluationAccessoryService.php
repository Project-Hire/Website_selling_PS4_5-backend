<?php

namespace App\Services;

use App\Models\Evaluation_Accessory;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class EvaluationAccessoryService
{
    public function getAll($limit, $page, $keyword){
        $data = Evaluation_Accessory::with(['user', 'accessory'])
            ->whereIn('user_id', function (Builder $q) use ($keyword) {
                $q->select('id')
                    ->from('users')
                    ->where('name', 'like',"%{$keyword}%");
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
        $data = Accessory::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('evaluation_accessory')->delete($id);

        return $result;
    }
}
