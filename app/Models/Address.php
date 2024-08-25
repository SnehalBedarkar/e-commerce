<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['name','phone_number' ,'postal_code' ,'locality' ,'address' ,'city','state' ,'landmark' ,'alternate_phone_number','type',];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
