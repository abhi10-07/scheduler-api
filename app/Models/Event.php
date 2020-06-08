<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['user_id', 'name', 'duration'];

    public function schedule() {
        return $this->hasOne('Schedule', 'event_id', 'id');
    }
}
