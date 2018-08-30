<?php

namespace OnrampWooCustomEmailsPlus\App\Feature\ShowAllActions;

use OnrampWooCustomEmailsPlus\App\ServiceProvider;
use OnrampWooCustomEmailsPlus\OnrampMini\Lib\WordpressDispaly;

class ShowAllActions
{

    public function perform(ServiceProvider $provider)
    {
        if (WP_DEBUG && true) {
            add_action('shutdown', [$this, 'showAllActions']);
        }
    }

    /**
     * 通常於 staging 使用
     * 如果要檢查操作的順序以及每個操作的觸發次數，那麼您可以使用
     */
    public function showAllActions()
    {
        $message = '<pre>' . print_r($GLOBALS['wp_actions'], true) . '</pre>';

        $display = new WordpressDispaly();
        $display->info($message);
        $display->showAll();
    }

}
