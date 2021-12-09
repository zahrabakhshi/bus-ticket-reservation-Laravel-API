<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mockery\Generator\StringManipulation\Pass\Pass;

class Reserve extends Model
{
    use HasFactory;

    protected $fillable = ['trip_id','user_id'];

    public function trip(){
        return $this->belongsTo(Trip::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
