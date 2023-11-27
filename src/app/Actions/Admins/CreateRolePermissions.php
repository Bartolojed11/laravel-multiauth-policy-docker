<?php

namespace App\Actions\Admins;

use App\Models\RolePermissions;

class CreateRolePermissions
{
    private array $payload;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public function execute(): RolePermissions
    {
        return RolePermissions::create($this->payload);
    }
}
