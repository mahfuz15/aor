<?php

namespace Controllers;

use Framework\Cache\Cachier;
use Framework\Tools\Pagination;
use Framework\Http\Request\Request;
use Framework\Controller\Controller;
use Framework\Http\Notification\Notification;

class MiscController extends Controller
{

    public function clearCache(Request $request, Notification $notifier)
    {
        $cachier = new Cachier(CACHE_CLIENT);

        if ($cachier->flush() === true) {
            $notifier->successNote('Cache cleared successfully !');
        } else {
            $notifier->warningNote('There is no cache to clear !');
        }

        redirect();
    }

    public static function singleton()
    {
        return new static();
    }

}
