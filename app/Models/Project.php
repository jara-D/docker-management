<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $appends = ['state'];

    protected $fillable = [
        'name',
        'hash',
        'user_id',
        'type',
        'compose_yaml',
    ];

    public function containers()
    {
        return $this->hasMany(Container::class);
    }

    public function getStateAttribute(): string
    {
        if ($this->containers->count() == 0) {
            return 'stopped';
        }

        if ($this->containers->every(fn ($c) => $c->state === 'running')) {
            return 'healthy';
        }

        if ($this->containers->contains(fn ($c) => $c->state === 'running')) {
            return 'degraded';
        }

        return 'stopped';
    }
}


