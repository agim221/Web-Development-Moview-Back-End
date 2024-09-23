<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Year extends Model
{
    use HasFactory;

    protected $table = 'years';

    protected $fillable = [
        'year',
    ];

    public $timestamps = false;

    protected $primaryKey = "year";

    public function films(): HasMany {
        return $this->hasMany(Film::class, 'release_date', 'id');
    }
}