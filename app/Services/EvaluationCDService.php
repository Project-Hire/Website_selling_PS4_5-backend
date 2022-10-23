<?php

namespace App\Services;

use App\Models\Evaluation_Cd;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class EvaluationCDService
{
    public function getAll($limit, $page, $keyword){
        $data = Evaluation_Cd::with(['user', 'cd_game'])
            ->whereIn('user_id', function (Builder $q) use ($keyword) {
                $q->select('id')
                    ->from('users')
                    ->where('name', 'like',"%{$keyword}%");
            })
            ->offset(($page - 1) * 10)
            ->paginate($limit);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['user'] = $data[$i]->user;
            $data[$i]['cd_game'] = $data[$i]->cdGame;
            unset($data[$i]['cd_game_id']);
            unset($data[$i]['user_id']);
        }

        return $data;
    }

    public function getDetail($id){
        $data = Evaluation_Cd::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('evaluation_cd')->delete($id);

        return $result;
    }
}
