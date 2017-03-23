<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *  Users
 */
class User extends Model
{
    protected $fillable = [ 'firstName', 'lastName', 'email', 'password', 'image', 'role'];
    public $timestamps = false;
}
