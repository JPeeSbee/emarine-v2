<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Policy extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'policy_number',
        'agent_id',
        'user_created',
        'user_modified',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->relationship()
            ->orWhere('policy_number', 'like', '%'.$search.'%')
            ->orWhereHas('agent', function($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
            });
    }

    public function scopeRelationship($query)
    {
        return $query->with(['agent']);
    }
}
