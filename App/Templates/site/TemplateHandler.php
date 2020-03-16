<?php

namespace Templates\site;

use Framework\Http\Request\Request;
use Framework\Template\BaseTemplateHandler;
use Framework\Database\Connections\MySqliConnection;

/**
 *
 */
class TemplateHandler extends BaseTemplateHandler {

    protected $settings;
    protected $openGraph;
    protected $notifications;

    public function boot()
    {
        if (empty($this->request)) {
            $this->request = new Request(new \Framework\Http\Session\Session);
        }
        $this->loadSettings();
        $this->loadOG();
    }

    public function preRender()
    {
        $this->loadHeader();
    }

    public function postRender()
    {
        $this->loadFooter();
    }

    public function loadHeader()
    {
        if (empty($_GET['format']) || $_GET['format'] !== 'raw') {
            require 'head.php';
            require 'header.php';
        }
    }

    public function loadFooter()
    {
        if (empty($_GET['format']) || $_GET['format'] !== 'raw') {
            //$topTags = $this->topTags();

            require 'footer.php';
            require 'foot.php';
        }
    }


    private function loadSettings()
    {
        $siteController = new \Controllers\SiteController();
        $this->settings = $siteController->returnSettings();
    }

    public function updateTitle($title)
    {
        $this->settings->title = $title . ' - ' . $this->settings->title;

        return $this;
    }

    protected function loadOG()
    {
        $this->openGraph = new \stdClass();
        $this->openGraph->title = !empty($this->settings->title) ? $this->settings->title : SITE;
        $this->openGraph->site = SITE;
        $this->openGraph->type = 'website';
        $this->openGraph->url = CURRENT_URL;
        $this->openGraph->image = BASE_URL . 'images/og-default.jpg';
        $this->openGraph->fbAppId = !empty($this->settings->fb_app_id) ? $this->settings->fb_app_id : '';

        $this->openGraph->twitter_page = !empty($this->settings->twitter_page) ? $this->settings->twitter_page : '';
    }

    public function loadCustomOG($content)
    {
        if (empty($content)) {
            return $this;
        }
        $this->settings->keyword = !empty($content->meta_keys) ? $content->meta_keys : $this->settings->keyword;

        $this->settings->title = $this->openGraph->title = $content->title . ' - ' . $this->settings->title;
        $this->settings->description = $this->openGraph->description = !empty($content->meta_description) ? $content->meta_description : $this->settings->description;

        return $this;
    }


    public function loadCompanyOG($company)
    {
        if (empty($company)) {
            return $this;
        }

        $this->settings->title = $this->openGraph->title = $company->name . ' - ' . $this->settings->title;
        if (!empty($company->location)) {
            $this->settings->keyword = str_replace(' ', ', ', $company->name . ' ' . $company->location->city . ' ' . $company->location->state . ' job post ' . SITE) . ', ' . SITE;
        } else {
            $this->settings->keyword = str_replace(' ', ', ', $company->name . ' job post ' . SITE) . ', ' . SITE;
        }
        //$this->settings->description = $this->openGraph->description = $job->title . ' available at ' . $job->city . ', ' . $job->state . ' on ' . SITE;
        $this->settings->description = $this->openGraph->description = !empty($company->description) ? substr(str_replace('&nbsp;', '', strip_tags($company->description, '')), 0, 250) : $this->settings->description;

        return $this;
    }



    protected function printOG()
    {
        if ($this->openGraph->title != '') {
            echo '
    <meta property="og:title" content="' . $this->openGraph->title . '" />';
        }
        if ($this->openGraph->site != '') {
            echo '
    <meta property="og:site_name" content="' . $this->openGraph->site . '" />';
        }
        if ($this->openGraph->description != '') {
            echo '
    <meta property="og:description" content="' . $this->openGraph->description . '" />';
        }
        echo '
    <meta property="og:type" content="article" />';
        echo '
    <meta property="og:url" content="' . $this->openGraph->url . '" />';
        if ($this->openGraph->image != '') {
            echo '
    <meta property = "og:image" content = "' . $this->openGraph->image . '" />
    <meta property = "og:image:width" content = "600" />
    <meta property = "og:image:height" content = "400" />';
        }
        if ($this->openGraph->fbAppId != '') {
            echo '
    <meta property = "fb:app_id" content = "' . $this->openGraph->fbAppId . '" />';
        }
    }

    protected function printTwitterCard()
    {
        echo '
    <meta name = "twitter:card" content = "summary" />';
        if ($this->openGraph->twitter_page != '') {
            echo '
    <meta name = "twitter:site" content = "@' . $this->openGraph->twitter_page . '" />';
        }
        if ($this->openGraph->title != '') {
            echo '
    <meta name = "twitter:title" content = "' . $this->openGraph->title . '" />';
        }
        if ($this->openGraph->description != '') {
            echo '
    <meta name = "twitter:description" content = "' . $this->openGraph->description . '" />';
        }
        if ($this->openGraph->description != '') {
            echo '
    <meta name = "twitter:image" content = "' . $this->openGraph->image . '" />';
        }
    }


    public function addJs($js)
    {
        $this->jsFiles[] = $js;
    }

    public function getJs()
    {
        return $this->jsFiles;
    }

    public function addRawJs($js)
    {
        $this->rawJs[] = $js;
    }

    public function getRawJs()
    {
        return $this->rawJs;
    }

    public function topTags()
    {
        $tagController = new \Controllers\TagController();
        return $tagController->topTags();
    }

    public function activeUrl($url)
    {
        if (defined('SUB_URL') && $url === SUB_URL) {
            return 'class="active"';
        }

        return '';
    }

}
