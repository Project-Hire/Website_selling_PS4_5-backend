<?php

namespace App\Services;

use App\Models\Game_console;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class GameConsoleService
{
    public function getAll($limit, $page, $keyword){
        $data = Game_console::with(['trademark'])
            ->whereIn('trademark_id', function (Builder $q) use ($keyword) {
                $q->select('id')
                    ->from('trademarks')
                    ->where('name', 'like',"%{$keyword}%");
            })
            ->offset(($page - 1) * 10)
            ->paginate($limit);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['trademark_id'] = $data[$i]->trademark;
            unset($data[$i]['trademark_id']);
        }
        return $data;
    }

    public function getDetail($id){
        $data = Game_console::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('game_console')->delete($id);

        return $result;
    }
}
