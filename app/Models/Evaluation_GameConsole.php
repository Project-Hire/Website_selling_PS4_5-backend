<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation_GameConsole extends Model
{
    use HasFactory;
    protected $table = 'evaluation_gameconsole';

    protected $fillable = [
        'name', 'user_id', "comment", "stars", "game_console_id"
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
