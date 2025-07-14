<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // For validator/admin routes
            if ($request->is('validator*')) {
                return route('validator.login.form');
            }
            // For society/user routes
            return route('society.login.form');
        }

        return null;
    }
}
