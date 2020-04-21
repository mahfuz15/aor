<?php

namespace Controllers;

use Framework\Tools\Pagination;
use Framework\Http\Request\Request;
use Framework\Controller\Controller;
use Framework\Http\Notification\Notification;

class SiteController extends Controller {

    public function setting(Request $request, Notification $Notification)
    {
        $this->themes();
        $settings = $this->returnSettings();
        $themes = $this->themes();

        if ($request->isPost()) {
            $postData = (object) $request->getPostData();

            unset($postData->csrf_token);

            file_put_contents($this->settingPath(), '<?php return ' . var_export((array) $postData, true) . ';');

            $Notification->successNote('You have successfully updated site settings !');
            redirect();
        } else {
            return $this->loadView('settings', 'admin')->with(compact('settings', 'themes'));
        }
    }

    public function returnSettings()
    {
        $setUpFile = $this->settingPath();

        if (file_exists($setUpFile)) {
            return (object) (require $setUpFile);
        }
        return false;
    }

    protected function settingPath()
    {
        $setUpFile = ROOT . DS . 'var/settings/site.php';
        if (file_exists(dirname($setUpFile)) === false) {
            mkdir(dirname($setUpFile), 0775, true);
        }

        return $setUpFile;
    }

    public function themes()
    {
        $themeDIR = ROOT . DS . PUBLIC_DIR . '/assets/lte-admin/css/skins';
        $themeFiles = \Framework\FileSystem\FileManager::files($themeDIR);
        $themes = [];

        if (!empty($themeFiles)) {
            foreach ($themeFiles as $themeFile) {
                $filename = basename($themeFile, '.css');
                if ($filename !== '_all-skins' && strpos($filename, '.min') === false) {
                    $themes[] = str_replace('skin-', '', $filename);
                }
            }
        }
        return $themes;
    }

}
