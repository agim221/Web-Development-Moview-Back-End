<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'film_id',
        'user_id',
        'comment',
        'rating',
    ];

    public function films(): BelongsTo {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }    

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}