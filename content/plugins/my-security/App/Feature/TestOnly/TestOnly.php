<?php

namespace MySecurity\App\Feature\TestOnly;

use MySecurity\OnrampMini\Core\Controller;
use MySecurity\OnrampMini\Lib\WordpressDispaly;

class TestOnly extends Controller
{

    public function perform()
    {
        if (WP_DEBUG && true) {
            add_action('admin_init', [$this, 'testOnly']);
        }
    }

    /**
     * 通常於 staging 使用
     * 如果要檢查操作的順序以及每個操作的觸發次數，那麼您可以使用
     */
    public function testOnly()
    {
        $message = 'test only';

        $display = new WordpressDispaly();
        $display->info($message);
        $display->showAll();
    }

}
