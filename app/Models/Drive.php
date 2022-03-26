<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drive extends Model
{
  use HasFactory;
  protected $fillable = [
    'name',
    'user_id',
    'file_id',
    'slug',
    'file_size',
    'mime_type',
    'thumb',
    'down_count'
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function ads()
  {
    return $this->belongsTo(Ads::class);
  }
}
