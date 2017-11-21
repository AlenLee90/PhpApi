<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	protected $fillable = ['account', 'email', 'password'];
	
	protected $hidden = [
        'password', 'remember_token',
    ];
	
    use HasApiTokens, Notifiable;
}