<?php

namespace App\Services;

use App\Models\PaymentGameConsole;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PaymentGameConsoleService
{
    public function getAll($limit, $page, $keyword){
        $data = PaymentGameConsole::with(['user', 'game_console'])
            ->whereIn('user_id', function (Builder $q) use ($keyword) {
                $q->select('id')
                    ->from('users')
                    ->where('name', 'like',"%{$keyword}%");
            })
            ->offset(($page - 1) * 10)
            ->paginate($limit);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['user'] = $data[$i]->user;
            $data[$i]['game_console'] = $data[$i]->gameConsole;
            unset($data[$i]['game_console_id']);
            unset($data[$i]['user_id']);
        }

        return $data;
    }

    public function getDetail($id){
        $data = PaymentGameConsole::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('payment_gameconsole')->delete($id);

        return $result;
    }
}
