<?php

declare(strict_types=1);

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentSportCategory extends Model
{
    use HasFactory;

    protected $table = 'sport_categories';

    public $timestamps = true;

    protected $guarded = ['id'];
}
