<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardLayout extends Model
{
    protected $fillable = ['user_id', 'widget_key', 'position', 'visible', 'width', 'colspan'];

    protected $casts = [
        'visible' => 'boolean',
        'position' => 'integer',
        'colspan' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
