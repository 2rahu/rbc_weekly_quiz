<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserCheck
{

    public function handle(Request $request, Closure $next): Response
    {
         if(session()->has('role') && session()->get('role')=='user'){
            return $next($request);
         }
         return redirect()->route('login.index');

    }
}
