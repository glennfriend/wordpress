<?php

namespace Onramp_Woo_Custom_Emails_Plus\App\Service;

use OnrampMini\Lib\WordpressDispaly;

/**
 * Class DebugInfoService
 */
final class DebugInfoService
{

    public function __construct()
    {
        $this->display = new WordpressDispaly();
    }

    public function perform()
    {
        add_action('shutdown', [$this, 'showAllActions']);
    }

    /**
     * 通常於 staging 使用
     * 如果要檢查操作的順序以及每個操作的觸發次數，那麼您可以使用
     */
    public function showAllActions()
    {
        $message = '<pre>' . print_r($GLOBALS['wp_actions'], true) . '</pre>';
        $this->display->info($message);
        $this->display->showAll();
    }

}
