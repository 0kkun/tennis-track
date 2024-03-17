<?php

declare(strict_types=1);

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentFavoritePlayer extends Model
{
    use HasFactory;

    protected $table = 'favorite_players';

    public $timestamps = true;

    protected $guarded = ['id'];

    /****  リレーション ****/

    public function user()
    {
        return $this->belongsTo(EloquentUser::class);
    }

    public function player()
    {
        return $this->belongsTo(EloquentPlayer::class);
    }
}
