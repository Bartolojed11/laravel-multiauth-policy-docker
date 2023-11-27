<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'admin_id';

    /**
     * 
     *
     * @return HasMany
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'created_by', 'admin_id');
    }

    /**
     * The roles that belong to the user.
     */
    public function role(): hasOne
    {
        return $this->hasOne(Role::class, 'role_id', 'role_id');
    }
}
