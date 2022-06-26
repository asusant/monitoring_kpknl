<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Bobb\Services\BAuth;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo()
    {
        if(Auth::guest())
        {
            return redirect(route((new BAuth)->login_route))->withErrors("Anda Harus login terlebih dahulu.");
        }
        else
        {
            return redirect(route((new BAuth)->login_redirect))->withErrors("Akses tidak diperbolehkan.");
        }
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return $this->redirectTo($request);
            }
        }

        // route name
        $route_name = $request->route()->getName();

        // determine privileges
        $route_split = explode('.',$route_name);
        $route_prefix = $route_split[0];

        if(count($route_split) == 1)
        {
            // default view
            $action = "index";
        }
        else
        {
            $action = end($route_split);
        }

        $allow = (new BAuth)->cekAkses($route_prefix,$action,true);

		if($allow[0] == false)
            return $this->redirectTo();

        config(['bobb.akses' => $allow[1]]);
        return $next($request);
    }
}
