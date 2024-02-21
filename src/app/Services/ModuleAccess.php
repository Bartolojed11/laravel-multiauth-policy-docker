<?php

namespace App\Services;

use App\Facades\Permission;

class ModuleAccess
{
    private $cacheKey;
    private $module;

    /**
     * Initialize cache key and module
     *
     * @param integer $user_id
     * @param string $module
     * @param string|null $cacheKey
     */
    public function __construct(int $user_id, string $module, string $cacheKey = null)
    {
        $this->cacheKey = !$cacheKey ? config('cache.admin-key') . $user_id : $cacheKey;
        $this->module = $module;
    }

    /**
     * Check wether a user has permission to read/view specific module
     *
     * @param string $module
     *
     * @return bool
     */
    public function canRead(): bool
    {
        return $this->canAccess($this->getModulesActions()['read']);
    }

    /**
     * Check wether a user has permission to write on specific module
     *
     * @param string $module
     *
     * @return bool
     */
    public function canWrite(): bool
    {
        return $this->canAccess($this->getModulesActions()['write']);
    }

    /**
     * Check wether a user has permission to update specific module
     *
     * @param string $module
     *
     * @return bool
     */
    public function canUpdate(): bool
    {
        return $this->canAccess($this->getModulesActions()['update']);
    }

    /**
     * Check wether a user has permission to delete the specific module
     *
     * @param string $module
     *
     * @return bool
     */
    public function canDelete(): bool
    {
        return $this->canAccess($this->getModulesActions()['delete']);
    }

    /**
     * Check if user can access the specified module
     *
     * @param string $module
     * @param string $action
     *
     * @return bool
     */
    private function canAccess(string $action): bool
    {
        $permissions = Permission::getPermissions($this->cacheKey);
        if (!$permissions) {
            return false;
        }
        return $permissions?->{$this?->module}?->$action ?? false;
    }

    /**
     * Get all the module permissions available
     *
     * @param string $module
     *
     * @return array
     */
    private function getModulesActions(): array
    {
        return config('modules.' . $this->module . '.permissions');
    }
}
