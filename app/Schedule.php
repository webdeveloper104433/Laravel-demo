<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'name', 'date', 'time', 'type', 'line1', 'line2', 'line3', 'image_id'
    ];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
