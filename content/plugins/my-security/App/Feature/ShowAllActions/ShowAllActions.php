<?php

namespace MySecurity\App\Feature\ShowAllActions;

use MySecurity\OnrampMini\Core\Controller;
use MySecurity\OnrampMini\Lib\WordpressDispaly;

class ShowAllActions extends Controller
{

    public function perform()
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
