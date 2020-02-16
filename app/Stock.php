<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
  /**
   * Get the Stock record associated with the user.
   */
  public function user()
  {
      return $this->belongsTo('App\User');
  }
}
