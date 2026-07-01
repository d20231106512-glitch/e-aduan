<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolum yang dibenarkan untuk diisi (Mass Assignment).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_matrik',
        'staff_id',
    ];

    /**
     * Kolum yang disorokkan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Penukaran jenis data (Casting).
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}