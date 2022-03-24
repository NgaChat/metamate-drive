<?php

namespace App\Models;

use App\Models\Drive;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'user_email',
        'image',
        'google_id',
        'remember_token'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    // public function createToken()
    // {
    //     //
    // }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    public function drive()
    {
        return $this->hasMany(Drive::class);
    }

    public function ads()
    {
        return $this->hasOne(Ads::class);
    }
}
