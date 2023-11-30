<?php

namespace App\Services\Permissions;

use Illuminate\Support\Facades\Redis;

class Permission
{
    public const CACHE_PREFIX = 'admin-';

    /**
     * Check wether a user has permission to read/view specific module
     *
     * @param string $module
     *
     * @return bool
     */
    public function canRead(string $module): bool
    {
        return $this->canAccess($module, $this->getModulesActions($module)['read']);
    }

    /**
     * Check wether a user has permission to write on specific module
     *
     * @param string $module
     *
     * @return bool
     */
    public function canWrite(string $module): bool
    {
        return $this->canAccess($module, $this->getModulesActions($module)['write']);
    }

    /**
     * Check wether a user has permission to update specific module
     *
     * @param string $module
     *
     * @return bool
     */
    public function canUpdate(string $module): bool
    {
        return $this->canAccess($module, $this->getModulesActions($module)['update']);
    }

    /**
     * Check wether a user has permission to delete the specific module
     *
     * @param string $module
     *
     * @return bool
     */
    public function canDelete(string $module): bool
    {
        return $this->canAccess($module, $this->getModulesActions($module)['delete']);
    }

    /**
     * Set the value of permission cache
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        if (Redis::get(self::CACHE_PREFIX . $key)) {
            Redis::purge(self::CACHE_PREFIX . $key);
        }
        Redis::set(self::CACHE_PREFIX . $key, json_encode($value));
    }

    /**
     * Get permission cache
     *
     * @return array
     */
    public function getPermissions(): array
    {
        $cache = Redis::get($this->cacheKey());
        return $cache ? json_decode($cache) : [];
    }

    /**
     * Delete the permissions cache
     *
     * @return void
     */
    public function revoke(): void
    {
        if (Redis::get($this->cacheKey())) {
            Redis::purge($this->cacheKey());
        }
    }

    /**
     * Get all the module permissions available
     *
     * @param string $module
     *
     * @return array
     */
    private function getModulesActions(string $module): array
    {
        return config('modules.' . $module . '.permissions');
    }

    /**
     * Check if user can access the specified module
     *
     * @param string $module
     * @param string $action
     *
     * @return bool
     */
    private function canAccess(string $module, string $action): bool
    {
        $permissions = $this->getPermissions();
        if (! $permissions) {
            return false;
        }
        return $permissions[$module][$action] ?? false;
    }

    /**
     * Get the cache key for authenticated user
     *
     * @return string
     */
    private function cacheKey(): string
    {
        return self::CACHE_PREFIX . auth()?->user()?->admin_id;
    }
}
