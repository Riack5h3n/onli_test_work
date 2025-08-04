<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
	protected $table = 'staffs';
    protected $fillable = [
        'user_id',
        'position_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function trips()
    {
        return $this->hasMany(Trips::class, 'staff_id');
    }
}