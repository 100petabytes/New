<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

use App\Events\Illuminate\Mail\Events\UserRegisteredEvent;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    protected $address = 'this is tes address';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
      * the event map
      * @var array
      */


      protected $dispatchesEvents =[
        'created' => UserRegisteredEvent::class

      ];






}
