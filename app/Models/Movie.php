<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    /* public $fillable = ['imdb_id', 'name']; */
    protected $guarded = [];
    public $timestamps = false;
    /*
    *
    * The table associated with the model
    *
    * @var string
    *
    **/
    protected $table = 'movies';
}
