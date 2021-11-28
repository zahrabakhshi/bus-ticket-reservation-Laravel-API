<?php

namespace App\Models;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = ['national_code'];

    public function tickets(){
        return $this->morphMany(Ticket::class,'ticketable');
    }

}
