<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        foreach($permissions as $akses) {
            if(Auth::user()->group_user == $akses) {
                return $next($request);
            }
        }

        if( $request->is('api/*')){
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin akses yang diperlukan.'], 403);
        }else{
            return redirect()->route('admin.index')->withErrors(['error' => 'Anda tidak memiliki izin akses yang diperlukan.']);
        }
    }
}
