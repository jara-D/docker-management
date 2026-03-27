<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    protected $fillable = [
        'container_id',
        'name',
        'image',
        'image_id',
        'state',
        'status',
        'ports',
        'labels',
        'network_settings',
        'mounts',
        'project_id',
    ];

    protected $casts = [
        'ports' => 'array',
        'labels' => 'array',
        'network_settings' => 'array',
        'mounts' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
