<?php

namespace App\Models;

use App\Models\Ticket;
use App\Models\Passenger;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role){

        return in_array($role ,$this->roles()->pluck('name')->toArray());
    }

    public function buyTickets(){
        return $this->hasManyThrough(Ticket::class, Reserve::class);
    }


    public function tickets(){
        return $this->morphMany(Ticket::class, 'ticketable');
    }

    public function temporaryReserves(){
        return $this->hasMany(TemporaryReserve::class);
    }

    public function reserves(){
        return $this->hasMany(Reserve::class);
    }

}
