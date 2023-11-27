<?php

namespace App\Actions\Admins;

use App\Models\Role;

class CreateRole
{
    private array $payload;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public function execute(): Role
    {
        return Role::create($this->payload);
    }
}
