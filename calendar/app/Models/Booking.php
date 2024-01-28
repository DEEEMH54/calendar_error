<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table='Booking';
    protected $fillable=['title_booking','start_time_booking', 'end_time_booking', 'room_booking'];
}
