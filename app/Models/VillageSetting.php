<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageSetting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    public function scopeGroup($query, string $group)
    {
        return $query->where('group', $group);
    }
}
