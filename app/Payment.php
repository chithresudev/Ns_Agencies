<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  /**
   * Get the Payment record associated with the user.
   */
  public function user()
  {
      return $this->belongsTo('App\User');
  }

}
