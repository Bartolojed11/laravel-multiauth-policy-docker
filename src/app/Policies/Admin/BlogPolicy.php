<?php

namespace App\Policies\Admin;

use App\Facades\Permission;
use App\Models\Admin;
use App\Models\Blog;

class BlogPolicy
{
    protected const MODULE = 'blogs';

    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return Permission::canRead(self::MODULE);
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Blog $blog): bool
    {
        return Permission::canRead(self::MODULE);
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return Permission::canWrite(self::MODULE);
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Blog $blog): bool
    {
        return Permission::canUpdate(self::MODULE);
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Blog $blog): bool
    {
        return Permission::canDelete(self::MODULE);
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(Admin $admin, Blog $blog): bool
    {
        return false;
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Blog $blog): bool
    {
        return false;
    }
}
