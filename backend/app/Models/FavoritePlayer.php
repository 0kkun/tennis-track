<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoritePlayer extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = ['id'];

    /****  リレーション ****/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
