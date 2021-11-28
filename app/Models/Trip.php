<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable=['vehicle_id'];

    public function vehicle(){
        return$this->belongsTo(Vehicle::class);
    }

    public function locations(){
        return $this->hasMany(Location::class);
    }

    public function reserves(){
        return $this->hasMany(Reserve::class);
    }

    public function tickets(){
        return $this->hasManyThrough(Ticket::class, Reserve::class);
    }
}
