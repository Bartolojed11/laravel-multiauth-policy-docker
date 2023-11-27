<?php

namespace App\Actions\Admins;

use App\Models\Admin;

class CreateAdmin
{
    private array $payload;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public function execute(): Admin
    {
        return Admin::create($this->payload);
    }
}
