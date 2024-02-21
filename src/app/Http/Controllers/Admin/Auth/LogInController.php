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

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw new CustomAuthenticationException();
        }

        $token = $admin->createToken('auth-token')->plainTextToken;

        Permission::set($admin, config('cache.admin-key') . $admin->admin_id);

        return new LoginResource([
            'access_token' => $token,
            'email' => $admin->email,
            'name' => $admin->name,
        ]);
    }
}
