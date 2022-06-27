<?php

namespace App\Services;

use App\Models\Trademark;
use Illuminate\Support\Facades\DB;

class TrademarkService
{
    public function getAll($limit, $page, $keyword){
        $data = DB::table('trademarks')
            ->where('name', 'LIKE', "%{$keyword}%")
            ->offset(($page - 1)*10)
            ->paginate($limit);

        return $data;
    }

    public function getDetail($id){
        $data = Trademark::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('trademarks')->delete($id);

        return $result;
    }

    public function update($request){
        $id = $request->id;
        $image = $request->image;
        $name = $request->name;

        $result = DB::update('update advertisement set image = ?, name = ? where id = ?', [$image, $name, $id]);

        return $result;
    }

}
