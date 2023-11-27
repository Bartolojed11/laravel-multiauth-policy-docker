<?php

namespace App\Actions\Admins;

use App\Models\Module;

class CreateModule
{
    public function __construct()
    {

    }

    public function execute()
    {
        collect(config('modules'))->map(function($module) {
            Module::updateOrCreate($module);
        });
    }
}
