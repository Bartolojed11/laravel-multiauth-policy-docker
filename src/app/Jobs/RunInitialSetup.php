<?php

namespace App\Jobs;

use App\Actions\Admins\CreateAdmin;
use App\Actions\Admins\CreateModule;
use App\Actions\Admins\CreateRole;
use App\Actions\Admins\CreateRolePermissions;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Module;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RunInitialSetup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $email;
    public string $password;
    /**
     * Create a new job instance.
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (collect(Admin::first())->isNotEmpty() || collect(Role::first())->isNotEmpty()) return;

        // Run only this when there is no admin and roles record
        $this->createModules();
        $role = $this->createRole();
        $this->createRolePermissions($role);
        $this->createAdmin($role);
    }

    private function createModules(): void
    {
        (new CreateModule())->execute();
    }

    private function createRole(): Role
    {
        return (new CreateRole([
            'name' => 'super_admin'
        ]))->execute();
    }

    private function createRolePermissions(Role $role): void
    {
        collect(Module::active()->get())->each(function ($module) use ($role) {
            (new CreateRolePermissions([
                'read' => true,
                'write' => true,
                'update' => true,
                'delete' => true,
                'role_id' => $role->role_id,
                'module_id' => $module->module_id,
            ]))->execute();
        });
    }

    private function createAdmin(Role $role): Admin
    {
        return (new CreateAdmin([
            'name' => 'admin',
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => $role->role_id
        ]))->execute();
    }
}
