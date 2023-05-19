<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }

        // cek apakah user sudah login atau belum
        if (! $request->expectsJson()) {
            // cek apakah admin atau bukan
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin');
            } elseif($request->is('guru') || $request->is('guru/*')){
                return route('guru');
            } elseif($request->is('siswa') || $request->is('siswa/*')){
                return route('siswa');
            }
            return route('login');
        }

        
    }
}
