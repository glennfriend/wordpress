<?php

namespace MySecurity\App\Feature\RemoveWordpressInfo;

use MySecurity\OnrampMini\Core\Controller;

class RemoveWordpressInfo extends Controller
{
    /**
     *
     */
    public function perform()
    {
        /**
         * 移除網頁部份資訊
         *      <meta name="generator" content="WordPress 4.9.8" />
         *      <meta name="generator" content="WooCommerce 3.4.4" />
         */
        remove_action('wp_head', 'wp_generator');

        // 不清楚做了什麼
        //remove_action('wp_head', 'wlwmanifest_link');

        // 不清楚做了什麼
        //remove_action('wp_head', 'rsd_link');
    }

    public static function getDescription()
    {
        $content = <<<"EOD"
移除網頁部份資訊, example:

     <meta name="generator" content="WordPress 4.9.8" />
     <meta name="generator" content="WooCommerce 3.4.4" />

EOD;

        return '<pre>' . htmlspecialchars($content) . '</pre>';
    }
}
