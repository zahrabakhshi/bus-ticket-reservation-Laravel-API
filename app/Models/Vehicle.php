<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'plate', 'company_id'
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function trips(){
        return $this->hasMany(Trip::class);
    }
}
