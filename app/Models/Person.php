<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;
    protected $table = 'personne';

    protected $fillable = [
        'identifier', 'first_name', 'father_name', 'grandfather_name', 
        'last_name', 'dob', 'address', 'job', 'phone', 'social', 
        'upbringing', 'education', 'level', 'work_history', 'religion', 
        'dawah', 'books', 'travels', 'friends', 'notes', 'latitude', 'longitude', 'photo',
        'country', 'governorate', 'delegation', 'sector'
    ];
}
