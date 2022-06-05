<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation_Cd extends Model
{
    use HasFactory;
    protected $table = 'evaluation_cd';

    protected $fillable = [
        'name', 'user_id', "comment", "stars", "cd_game_id"
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
