<?php

namespace App\Jobs;

use App\Actions\Admins\CreateAdmin;
use App\Actions\Admins\CreateModule;
use App\Actions\Admins\CreateRole;
use App\Actions\Admins\CreateRolePermissions;
use App\Models\Admin;
use App\Models\Module;
use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class RunInitialSetup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $email;
    protected string $password;
    protected string $name;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $password, $name = 'admin')
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (
            collect(Admin::first())->isEmpty()
            && collect(Role::first())->isEmpty()
        ) {
            $this->createModules();
            $role = $this->createRole();
            $this->createRolePermissions($role);
            $this->createAdmin($role);
        }
    }

    private function createModules(): void
    {
        (new CreateModule())->execute();
    }

    private function createRole(): Role
    {
        return (new CreateRole([
            'name' => 'super_admin',
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
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => $role->role_id,
        ]))->execute();
    }
}
