<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public $table = 'user_roles';

    public $fillable = [
        'user_id', 'role_id',
    ];

    public $validation = [
        'user_id' => 'integer|exists:users,id',
        'role_id' => 'integer|exists:roles,id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}