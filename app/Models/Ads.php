<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ads extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'leftside_image',
    'leftside_redirect_url',
    'rightside_image',
    'rightside_redirect_url',
    'banner_image',
    'banner_redirect_url'
  ];

  public function user()
  {
    return $this->BelongsTo(User::class);
  }

  public function drive()
  {
    return $this->hasMany(Drive::class);
  }
}
