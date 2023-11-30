<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'role_id';

    public function permissions(): HasMany
    {
        return $this->hasMany(RolePermissions::class, 'role_id', 'role_id');
    }

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'role_id', 'role_id');
    }
}
