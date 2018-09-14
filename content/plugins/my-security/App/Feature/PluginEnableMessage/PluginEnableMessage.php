<?php

namespace MySecurity\App\Feature\PluginEnableMessage;

use MySecurity\OnrampMini\Core\Controller;
use MySecurity\OnrampMini\Lib\WordpressDispaly;
use MySecurity\OnrampMini\Lib\WordpressPluginHelper;

class PluginEnableMessage extends Controller
{
    /**
     *
     */
    public function perform()
    {
        $file = $this->provider->file;
        $this->display = new WordpressDispaly();
        $this->helper = new WordpressPluginHelper(dirname($this->provider->file));

        $cacheName = $this->helper->getNamespace() . '_activate_plugin_trigger';

        register_activation_hook($file, function($key) use ($cacheName) {
            set_transient($key, true);
        });

        add_action('admin_notices', function($key) use ($cacheName) {
            if (get_transient($key)) {
                delete_transient($key);
                $this->showEnablePluginInfo();
            }
        });
    }

    /**
     * 在每一次 enable plguin 的時候, 會顯示的說明文字
     */
    public function showEnablePluginInfo()
    {
        $message = <<<"EOD"
Welcom enable {$this->provider->name}
EOD;

        $this->display->info($message);
        $this->display->showAll();
    }


}
