<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation_GiftCard extends Model
{
    use HasFactory;
    protected $table = 'evaluation_giftcard';

    protected $fillable = [
        'name', 'user_id', "comment", "stars", "gift_card_id"
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
