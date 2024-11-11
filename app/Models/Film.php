<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Film extends Model
{
    use HasFactory;

    protected $table = 'films';

    protected $fillable = [
        'title',
        'image',
        'description',
        'release_date',
        'rating',
        'country_id',
        'status',
        'trailer',
        'availability',
    ];

    public $timestamps = false;

    public function country(): BelongsTo {
        return $this->belongsTo(Country::class, 'country', 'id');
    }

   public function year(): BelongsTo {
        return $this->belongsTo(Year::class, 'release_date', 'id');
    }

    public function awards(): HasMany {
        return $this->hasMany(FilmAward::class, 'film_id', 'id');
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class, 'film_id', 'id');
    }

    public function trending(): HasOne {
        return $this->hasOne(Trending::class, 'film_id', 'id');
    }

    public function genres(): HasMany {
        return $this->hasMany(FilmGenre::class, 'film_id', 'id');
    }

    public function actors(): HasMany {
        return $this->hasMany(ActorFilm::class, 'film_id', 'id');
    }

    public function updateRating()
    {
        $averageRating = $this->comments()->avg('rating');
        $this->rating = $averageRating;
        $this->save();
    }
}
