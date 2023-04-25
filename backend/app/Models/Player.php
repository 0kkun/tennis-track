<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = ['id'];

    public const ITEM_PER_PAGE = 20;

    /**
     * バックハンドスタイル
     */
    private const BACKHAND_STYLE = [
        0 => '片手',
        1 => '両手',
    ];

    /**
     * 性別
     */
    private const GENDER = [
        0 => '男',
        1 => '女',
    ];

    /**
     * 利き腕
     */
    private const DOMINANT_ARM = [
        0 => '右',
        1 => '左',
        2 => '両',
    ];

    /**
     * バックハンドスタイルをテキストに変換する
     *
     * @return string|null
     */
    public function convertBackhandStyleString(): string|null
    {
        if (!$this->backhand_style) return null;
        return self::BACKHAND_STYLE[$this->backhand_style];
    }

    /**
     * 性別をテキストに変換する
     *
     * @return string|null
     */
    public function convertGenderString(): string|null
    {
        if (!$this->gender) return null;
        return self::GENDER[$this->gender];
    }

    /**
     * 利き腕をテキストに変換する
     *
     * @return string|null
     */
    public function convertDominantArmString(): string|null
    {
        if (!$this->dominant_arm) return null;
        return self::DOMINANT_ARM[$this->dominant_arm];
    }

    /**
     * 生年月日から年齢を取得する
     *
     * @return integer|null
     */
    public function getAge(): int|null
    {
        if (!$this->birthday) return null;
        $birthday = Carbon::parse($this->birthday);
        $now = Carbon::now();
        return $birthday->diffInYears($now);
    }

    /****  リレーション ****/

    public function sportCategory()
    {
        return  $this->belongsTo(SportCategory::class);
    }
}
