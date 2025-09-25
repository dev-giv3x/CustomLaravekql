<?php

namespace Middlewares;

use Src\Request;

class SpecialCharsMiddleware
{
    public function handle(Request $request):Request
    {
        foreach ($request->all() as $key => $value) {
            $request->set($key, is_string($value) ? htmlspecialchars($value) : $value);
        }
        return $request;
    }
}
