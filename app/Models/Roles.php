<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = "roles";
    protected $primaryKey = 'role_id';

    protected $fillable = [
        'role'
    ];

    
}
