<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'email',
        'location_id',
        'user_created',
        'user_modified',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
