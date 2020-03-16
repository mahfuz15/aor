<?php

namespace MiddleWares;

use Closure;
use Framework\Http\Request\Request;
use Framework\Http\MiddleWare\MiddleWareInterface;

class RegularMiddleWare implements MiddleWareInterface {

    public function handle(Request $request, Closure $next)
    {
        if (strpos(CURRENT_MAINURL, BASE_URL . ADMIN_PANEL_NAME) !== false) {
            define('PANEL', ADMIN_PANEL_NAME);
        } else {
            define('PANEL', USER_PANEL_NAME);
        }

        return $next($request);
    }



}
