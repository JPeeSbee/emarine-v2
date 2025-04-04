<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'lgt_tax_rate',
        'agent_id',
        'email_recepient',
        'user_created',
        'user_modified',
    ];

    public function agent()
    {
        $this->hasMany(Agent::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%'.$search.'%')
            ->orWhere('address', 'like', '%'.$search.'%')
            ->orWhere('lgt_tax_rate', 'like', '%'.$search.'%')
            ->orWhere('email_recepient', 'like', '%'.$search.'%');
    }
}
