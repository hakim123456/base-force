<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personne extends Model
{
    use SoftDeletes;
    // The table associated with the model.
    protected $table = 'personne';

    // The attributes that are mass assignable.
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'date_naissance',
        'photo',
    ];
}
