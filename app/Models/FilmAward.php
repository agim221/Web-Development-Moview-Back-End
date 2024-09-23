<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilmAward extends Model
{
    use HasFactory;

    protected $table = 'films_awards';

    protected $fillable = [
        'film_id',
        'award_id',
    ];

    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey = ['film_id', 'award_id'];
    protected $keyType = 'string';

    public function film(): BelongsTo {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

    public function award(): BelongsTo {
        return $this->belongsTo(Award::class, 'award_id', 'id');
    }
}
