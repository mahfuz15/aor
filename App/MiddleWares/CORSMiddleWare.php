<?php

namespace MiddleWares;

use Closure;
use Framework\Http\Request\Request;
use Framework\Http\MiddleWare\MiddleWareInterface;

class CORSMiddleWare implements MiddleWareInterface {

    public function handle(Request $request, Closure $next)
    {

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Requested-With, Authorization');

        return $next($request);
    }

}
