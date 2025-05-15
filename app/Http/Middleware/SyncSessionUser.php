<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SyncSessionUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            DB::table('sessions')
                ->where('id', Session::getId())
                ->update(['user_id' => Auth::id()]);
        }

        return $next($request);
    }
}
