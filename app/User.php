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
        'name', 'email', 'password', 'user_role_id', 'phone_number', 'birthday', 'about', 'hired_date', 'fired_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\UserRole', 'user_role_id');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('fired_date');
    }

    public function scopeFired($query)
    {
        return $query->whereNotNull('fired_date');
    }

    public function isAdmin()
    {
        if($this->role->id == 1)
            return true;
        else
            return false;
    }

    public function actions()
    {
        return $this->hasMany('App\Action', 'manager_user_id');
    }

    public function clients()
    {
        return $this->hasMany('App\Client', 'manager_user_id');
    }
}