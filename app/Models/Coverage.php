<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coverage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'rate_percent',
        'user_created',
        'user_modified',
    ];
    
    public function details()
    {
        return $this->hasMany(CoverageDetail::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%'.$search.'%')
            ->orWhere('code', 'like', '%'.$search.'%')
            ->orWhere('rate_percent', 'like', '%'.$search.'%');
    }

    public function scopeRelationship($query)
    {
        return $query->with(['details']);
    }
}
