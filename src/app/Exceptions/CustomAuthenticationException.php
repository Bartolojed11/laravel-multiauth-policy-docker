<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomAuthenticationException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): Response
    {
        return response([
            'message' => 'Invalid email or password!',
            'error' => 'Unauthenticated',
        ], 401);
    }
}
