<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'device';
    protected $fillable = [
        'device_code', 'description', 'timestamp_registered', 'timestamp_last_accessed'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}