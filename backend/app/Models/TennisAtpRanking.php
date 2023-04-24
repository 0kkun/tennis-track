<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TennisAtpRanking extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = ['id'];

    public const ITEM_PER_PAGE = 150;

    /****  リレーション ****/

    public function player()
    {
        return  $this->belongsTo(Player::class);
    }
}
