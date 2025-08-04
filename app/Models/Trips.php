<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trips extends Model
{
    protected $fillable = [
        'staff_id',
        'car_id',
        'start_time',
        'end_time',
        'destination',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function car()
	{
        return $this->belongsTo(Car::class);
    }
}