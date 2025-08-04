<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarComfortClass extends Model
{
    protected $fillable = ['name'];
    protected $table = 'car_comfort_class';

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'usr_categ_and_cars');
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}