<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Facades\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        Permission::revoke();
        $request->user('admin')->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out successfully!',
        ]);
    }
}
