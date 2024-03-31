<?php

declare(strict_types=1);

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentTennisRanking extends Model
{
    use HasFactory;

    protected $table = 'tennis_rankings';

    public $timestamps = true;

    protected $guarded = ['id'];

    public const ITEM_PER_PAGE = 150;

    /****  リレーション ****/

    public function player()
    {
        return $this->belongsTo(EloquentTennisPlayer::class);
    }
}
