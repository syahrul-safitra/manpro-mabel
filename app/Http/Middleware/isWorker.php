<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isWorker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // jika belum login
        if(!auth()->check()) {
            return redirect('/login');
        } 

        // jika sudah login tapi bukan admin, maka lempar ke url('/user-wroker')
        if (auth()->user()->is_admin) {
            return redirect('/');
        }

        return $next($request);
    }
}
