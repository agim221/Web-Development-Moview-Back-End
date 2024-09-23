<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actor extends Model
{
    use HasFactory;

    protected $table = 'actors';

    protected $fillable = [
        'name',
        'image',
    ];

    public $timestamps = false;

    public function acted_in(): HasMany {
        return $this->hasMany(ActorFilm::class, 'actor_id', 'id');
    }
}
