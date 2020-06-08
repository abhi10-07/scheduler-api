<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function event() {
        return $this->belongsTo(Event::class, 'type_id', 'id');
    }
}
