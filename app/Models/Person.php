<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'identifier', 'first_name', 'father_name', 'grandfather_name', 
        'last_name', 'dob', 'address', 'job', 'phone', 'social', 
        'upbringing', 'education', 'level', 'work_history', 'religion', 
        'dawah', 'books', 'travels', 'friends', 'notes', 'latitude', 'longitude'
    ];
}
