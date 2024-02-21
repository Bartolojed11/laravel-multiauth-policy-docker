<?php

namespace App\Services\Permissions;

use App\Models\Admin;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;
use stdClass;

class Permission
{
    /**
     * Set the value of permission cache
     *
     * @param Admin $user
     *
     * @return void
     */
    public function set(Admin $user, string $key): void
    {
        $permissions = $this->generatePermissions($user);
        if (Redis::get($key)) {
            Redis::purge($key);
        }
        Redis::set($key, json_encode($permissions));
    }

    /**
     * Get permission cache
     *
     * @param string $key
     * @return stdClass
     */
    public function getPermissions(string $key): stdClass
    {
        $cache = Redis::get($key);
        return $cache ? json_decode($cache) : [];
    }

    /**
     * Delete the permissions cache
     *
     * @return void
     */
    public function revoke($key): void
    {
        if (Redis::get($key)) {
            Redis::purge($key);
        }
    }

    /**
     * Generate Permissions of logged ni user
     *
     * @param Admin $user
     * @return Collection
     */
    private function generatePermissions(Admin $user): Collection
    {
        $roles_permissions = $user->role()->with('permissions')->get();
        return collect($roles_permissions->first()->permissions)->mapWithKeys(function ($permission) {
            $module = $permission->module()->first('name');
            return [
                $module->name => [
                    'read' => $permission->read ?? false,
                    'write' => $permission->write ?? false,
                    'update' => $permission->update ?? false,
                    'delete' => $permission->delete ?? false,
                ]
            ];
        });
    }
}
