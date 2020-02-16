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

  /**
   * Get the Payment record associated with the user.
   */
  public function getCreatedAttribute()
  {
      return Carbon::parse($this->created_at)->format('Y M d');
  }
  
}
