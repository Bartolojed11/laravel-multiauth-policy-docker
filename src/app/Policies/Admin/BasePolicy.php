<?php

namespace App\Policies\Admin;

use App\Services\ModuleAccess;
use Illuminate\Support\Facades\Log;

class BasePolicy
{
    public $moduleAccess;
    public string $module;
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        $this->moduleAccess = new ModuleAccess(auth('admin')->user()->admin_id, $this->module);
    }
}
