<?php

namespace App\Services;

use App\Models\Accessory;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class AccessoryService
{
    public function getAll($limit, $page, $keyword){
        $data = Accessory::with(['trademark'])
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
        $data = Accessory::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('accessory')->delete($id);

        return $result;
    }

    public function update($request){
        $id = $request->id;
        $name = $request->name;
        $type_movie = $request->type_of_movie;
        $range_age = $request->range_age;
        $dimension = $request->dimension;
        $range_of_movie = $request->range_of_movie;
        $start_date = $request->start_date;
        $poster = $request->poster;
        $actor = $request->actor;
        $direct = $request->direct;
        $description = $request->description;
        $trailer = $request->trailer;

        $result = DB::update('update cd_games set name = ?, type_of_movie= ?, range_age= ?, dimension= ?, range_of_movie= ?, poster= ?, start_date= ?, actor= ?, director= ?, description= ?, trailer = ?  where id = ?', [$name,$type_movie, $range_age, $dimension, $range_of_movie,$poster, $start_date, $actor, $direct, $description, $trailer, $id]);

        return $result;
    }
}
