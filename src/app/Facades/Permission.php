<?php

namespace App\Facades;

use App\Services\Permissions\Permission as PermissionService;
use Illuminate\Support\Facades\Facade;

class Permission extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PermissionService::class;
    }
}
