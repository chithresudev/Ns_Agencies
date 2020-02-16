<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
  /**
   * Get the Fuels record associated with the user.
   */
  public function user()
  {
      return $this->belongsTo('App\User');
  }

}
