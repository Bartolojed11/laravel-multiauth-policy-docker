<?php

namespace App\Policies\Admin;

use App\Models\Admin;
use App\Models\Blog;
use App\Policies\Admin\BasePolicy;

class BlogPolicy extends BasePolicy
{
    public string $module = 'blogs';
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $this->moduleAccess->canRead();
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Blog $blog): bool
    {
        return $this->moduleAccess->canRead();
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return $this->moduleAccess->canWrite();
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Blog $blog): bool
    {
        return $this->moduleAccess->canUpdate();
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Blog $blog): bool
    {
        return $this->moduleAccess->canDelete();
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
