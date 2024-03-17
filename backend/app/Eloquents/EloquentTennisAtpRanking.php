<?php
declare(strict_types=1);

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentTennisAtpRanking extends Model
{
    use HasFactory;

    protected $table = 'tennis_atp_rankings';

    public $timestamps = true;

    protected $guarded = ['id'];

    public const ITEM_PER_PAGE = 150;

    /****  リレーション ****/

    public function player()
    {
        return $this->belongsTo(EloquentPlayer::class);
    }
}
