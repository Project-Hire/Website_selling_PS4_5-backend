<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCDGame extends Model
{
    use HasFactory;

    protected $table = 'payment_cd_games';

    protected $fillable = [
        "cd_games_id", "user_id", "money", "email", 'quantity'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function cdGame(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cd_game::class, "cd_games_id");
    }
}
