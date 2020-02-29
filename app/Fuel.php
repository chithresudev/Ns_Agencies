<?php

namespace App;
use Carbon\Carbon;
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

  /**
   * Get the Payment record associated with the user.
   */
  public function getCreatedAttribute()
  {
      return Carbon::parse($this->created_at)->format('Y M d');
  }

  /**
   * Get the Payment record associated with the user.
   */
  public function getInsertAttribute()
  {
      return Carbon::parse($this->insert_date)->format('Y M d');
  }

}
