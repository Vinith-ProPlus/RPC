<?php

namespace App\Http\Middleware;

use App\helper\helper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckValidCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && Helper::checkValidCustomer($user->ReferID)) {
            return $next($request);
        }
        return redirect('/customer-profile');
    }
}
