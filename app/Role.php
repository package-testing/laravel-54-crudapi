<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    public $table = 'roles';
    public $fillable = [
        'name'
    ];
    public $validation = [
        'name' => 'string'
    ];
}
