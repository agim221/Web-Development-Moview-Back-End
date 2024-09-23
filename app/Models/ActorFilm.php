<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActorFilm extends Model
{
    use HasFactory;

    protected $table = 'actors_films'; // Pastikan nama tabel sesuai

    public $incrementing = false; // Nonaktifkan auto-incrementing ID
    public $timestamps = false; // Nonaktifkan timestamps

    protected $primaryKey = ['film_id', 'actor_id']; // Tentukan primary key komposit
    protected $keyType = 'string'; // Tentukan tipe data primary key

    protected $fillable = [
        'film_id',
        'actor_id',
    ];

    public function film(): BelongsTo {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

    public function actors(): BelongsTo {
        return $this->belongsTo(Actor::class, 'actor_Id', 'id');
    }
}