<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable =[
        'trip_id',
        'time_hit',
        'type',
        'town_id'
    ];

    public function trip(){
        return $this->belongsTo(Trip::class);
    }

    public function town(){
        return $this->belongsTo(Town::class);
    }
}
