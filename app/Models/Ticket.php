<?php

namespace App\Models;

use App\Models\User;
use App\Models\Passenger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['seat_number','reserve_id','ticketable_id'];

    public function ticketable(){
        $ret = $this->morphTo();
        return $ret;
    }


    public function reserve(){
        return $this->belongsTo(Reserve::class);
    }

    public function getTicketDataAttribute(){

        return [
            'id' => $this->id,
            'seat_number'  => $this->seat_number,
            'gender' => $this->ticketable->gender,
        ];
    }
}
