<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilmGenre extends Model
{
    use HasFactory;

    protected $table = 'films_genres';

    protected $fillable = [
        'film_id',
        'genre_id',
    ];

    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey = ['film_id', 'genre_id'];
    protected $keyType = 'string';

    public function film(): BelongsTo {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

    public function genre(): BelongsTo {
        return $this->belongsTo(Genre::class, 'genre_id', 'id');
    }
}
