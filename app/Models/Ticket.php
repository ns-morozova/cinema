<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    //protected $fillable = ['session_id', 'seat_id', 'qr_code', 'status'];
    protected $fillable = ['session_id', 'seat_id', 'qr_code'];

    // Связь с сеансом
    public function session()
    {
        return $this->belongsTo(MovieSession::class, 'session_id');
    }

    // Связь с креслом (один к одному)
    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seat_id');
    }    
}