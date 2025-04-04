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

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%'.$search.'%')
            ->orWhere('code', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%')
            ->orWhereHas('location', function($q) use ($search){
                $q->where('name', 'like', '%'.$search.'%');
            });
    }

    public function scopeRelationship($query)
    {
        return $query->with(['location']);
    }
}
