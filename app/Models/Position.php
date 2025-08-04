<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['name'];
	
    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }

    public function carComfortClasses()
	{
		return $this->belongsToMany(CarComfortClass::class, 'usr_categ_and_cars');
	}
}