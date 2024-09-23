<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trending extends Model
{
    use HasFactory;

    protected $fillable = [
        'film_id',
    ];

    public $timestamps = false;

    public function film(): BelongsTo {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }
}
