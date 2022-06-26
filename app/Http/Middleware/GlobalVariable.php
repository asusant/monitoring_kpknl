<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SysSetting;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Auth;
use DB;

class GlobalVariable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!cache('app_setting') || !cache('sys_setting'))
        {
            $app_setting = AppSetting::pluck('content', 'key')->toArray();
            $sys_setting = SysSetting::pluck('content', 'key')->toArray();
            cache(['app_setting' => $app_setting], now()->addHour());
            cache(['sys_setting' => $sys_setting], now()->addHour());
        }

        return $next($request);
    }
}
