<?php

namespace Middlewares;

use Exception;
use Src\Request;
use Src\Session;

class CSRFMiddleware
{
    public function handle(Request $request): void
    {
        if ($request->method !== 'POST') {
            return;
        }
        if (empty($request->get('csrf_token')) ||
            $request->get('csrf_token')!==Session::get('csrf_token')) {
            throw new Exception('Request not authorized');
        }
    }
}
