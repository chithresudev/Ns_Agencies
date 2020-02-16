<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the Fuel record associated with the user.
     */
    public function fuels()
    {
        return $this->hasMany('App\Fuel');
    }

    /**
     * Get the Fuel diesel record
     */
    public function dieselread()
    {
        return $this->fuels->where('fuel', 'diesel')->sum('read_value');
    }

    /**
     * Get the Fuel petrol record
     */
    public function petrolread()
    {
        return $this->fuels->where('fuel', 'petrol')->sum('read_value');
    }

    /**
     * Get the Payment record associated with the user.
     */
    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    /**
     * Get the payment diesel record
     */
    public function dieselpayment()
    {
        return $this->payments->where('fuel', 'diesel')->sum('in_amount');
    }

    /**
     * Get the payment petrol record
     */
    public function petrolpayment()
    {
        return $this->payments->where('fuel', 'petrol')->sum('in_amount');
    }

    /**
     * Get the Payment record associated with the user.
     */
    public function stocks()
    {
        return $this->hasMany('App\Payment');
    }

    /**
     * Get the payment diesel record
     */
    public function dieselstock()
    {
        return $this->stocks->where('fuel', 'diesel')->sum('in_stock');
    }

    /**
     * Get the payment petrol record
     */
    public function petrolstock()
    {
        return $this->stocks->where('fuel', 'petrol')->sum('in_stock');
    }


}
