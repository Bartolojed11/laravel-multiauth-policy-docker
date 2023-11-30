<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Exceptions\CustomAuthenticationException;
use App\Facades\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Resources\Admin\LoginResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class LogInController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            throw new CustomAuthenticationException();
        }

        $token = $admin->createToken('auth-token')->plainTextToken;

        $roles_permissions = $admin->with('role.permissions')->get()->pluck('role');
        $permissions = collect($roles_permissions->first()->permissions)->map(function ($permission) {
            $module = $permission->module()->first('name');
            return [
                $module->name ?? '' => [
                    'read' => $permission->read ?? false,
                    'write' => $permission->write ?? false,
                    'update' => $permission->update ?? false,
                    'delete' => $permission->delete ?? false,
                ],
            ];
        });

        Permission::set($admin->admin_id, $permissions);

        return new LoginResource([
            'access_token' => $token,
            'email' => $admin->email,
            'name' => $admin->name,
        ]);
    }
}
