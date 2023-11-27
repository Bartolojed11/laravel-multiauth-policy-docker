<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'module_id';

    public function permissions(): HasMany
    {
        return $this->hasMany(RolePermissions::class, 'module_id', 'module_id');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }
}
