<?php

namespace App\Actions\Admins;

use App\Models\Module;

class CreateModule
{
    public function execute()
    {
        collect(config('modules'))->map(function ($module) {
            Module::updateOrCreate($module['db']);
        });
    }
}
