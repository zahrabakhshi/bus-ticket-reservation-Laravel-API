<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryReserve extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'trip_id', 'seats_json'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
