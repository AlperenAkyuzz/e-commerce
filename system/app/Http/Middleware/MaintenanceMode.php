<?php

namespace App\Http\Middleware;

use App\Models\Generalsetting;
use Closure;
use Illuminate\Support\Facades\Auth;

class MaintenanceMode
{
    public function handle($request, Closure $next)
    {

        $gs = Generalsetting::find(1);
        // Eğer kullanıcı super admin ise bakım modu o kullanıcıyı etkilemesin.
        if (Auth::guard('admin')->check()) {
            if (Auth::guard('admin')->user()->IsSuper()){
                return $next($request);
            }
        }

        elseif ($gs->is_maintain == 1) {
            return redirect()->route('front-maintenance');
        }

        return $next($request);

    }
}
