<?php

namespace App\Models;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailServer extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  protected $hidden = ['password'];

  protected $casts = [
    'password' => 'encrypted',
  ];
}
