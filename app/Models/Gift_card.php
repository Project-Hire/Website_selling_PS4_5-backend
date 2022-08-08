<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift_card extends Model
{
    use HasFactory;
    protected $table = 'gift_card';

    protected $fillable = [
        'name', 'trademark_id', "description", "quantity", "discount", "price", "image", "viewer"
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function trademark(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Trademark::class, "trademark_id");
    }
}
