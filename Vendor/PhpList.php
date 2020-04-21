<?php
namespace Vendor;

use Framework\Http\Request\Request;
use Framework\DInjector\Singleton;
use Vendor\PHPList\PhpListApiClient;

class PhpList extends PhpListApiClient
{

    public function __construct()
    {
        /**
         * We are hardcoding everything
         * Bad for testing
         * But works okay now
         */
        $request = Singleton::get(Request::class);
        $userService = new \App\Services\UserService();
        $phplistService = new \App\Services\PhpListService();

        $user = $userService->userInfo($request->loggedID());

        /**
         * @var \Models\CompanyPhplistModel $phplistConfig Just for hint
         */
        $phplistConfig = $phplistService->getConfig($user->company_id);

        if (empty($phplistConfig)) {
            throw new \Exception('PhpList instance is not available !', 599);
        }
        parent::__construct($phplistConfig->target_url, $phplistConfig->username, $phplistConfig->password, $phplistConfig->secret);
    }

    public function unserialize($data)
    {
        if (strpos($data, 'SER:') === 0) {
            $data = unserialize(substr($data, 4));
        }

        return $data;
    }

    public function stripSlashes($data)
    {
        if (is_array($data)) {
            array_walk_recursive($data, function(&$value, $key) {
                $value = stripslashes($value);
            });

            return $data;
        }

        return stripslashes($data);
    }
}
