<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Award extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
    ];

    public $timestamps = false;

    public function film(): HasOne {
        return $this->hasOne(FilmAward::class, 'award_id', 'id');
    }
}
