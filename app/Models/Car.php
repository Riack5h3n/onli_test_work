<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public function comfortClass()
	{
		return $this->belongsTo(CarComfortClass::class, 'comfort_class_id');
	}

	public function driver()
	{
		return $this->belongsTo(Driver::class);
	}

	public function trips()
	{
		return $this->hasMany(Trips::class);
	}
}