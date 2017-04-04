<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  /**
   * Specify which attributes are mass assignable
   *
   * @var  array
   * @see  https://laravel.com/docs/5.4/eloquent#mass-assignment
   */
  protected $fillable = ['name', 'type'];
}
