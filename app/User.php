<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Determine if a user has a given role
     *
     * @param string|integer $role Role id or name.
     *
     * @return bool
     */
    public function hasRole($role)
    {
        if (!is_int($role)) {
            // Get the role id from it's name
            $r = Role::where('name', $role)->first();
            if ($r === null) {
                // If role doesn't exist return false;
                return false;
            }
            $role = $r->id;
        }
        try {
            $userRole = UserRole::where('user_id', $this->id)
                            ->where('role_id', $role)
                            ->firstOrFail();
            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
}
