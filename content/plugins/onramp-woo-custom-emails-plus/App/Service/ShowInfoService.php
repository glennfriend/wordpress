<?php

namespace Onramp_Woo_Custom_Emails_Plus\App\Service;

use OnrampMini\Lib\WordpressDispaly;
use OnrampMini\Lib\WordpressPluginHelper;


/**
 * Class ShowInfoService
 */
final class ShowInfoService
{

    public function __construct(string $pluginFile, int $priority)
    {
        $pluginDir = dirname($pluginFile);

        $this->file = $pluginFile;
        $this->priority = $priority;
        $this->display = new WordpressDispaly();
        $this->helper = new WordpressPluginHelper($pluginDir);
    }

    public function perform($message)
    {
        $cacheName = $this->helper->getNamespace() . '_activate_plugin_trigger';

        register_activation_hook($this->file, function($key) use ($cacheName) {
            set_transient($key, true);
        });

        add_action('admin_notices', function($key) use ($cacheName, $message) {
            if (get_transient($key)) {
                delete_transient($key);
                $this->showEnablePluginInfo($message);
            }
        });
    }

    /**
     *
     */
    public function showEnablePluginInfo($message)
    {
        if (! $message) {
            return;
        }
        $this->display->info($message);
        $this->display->showAll();
    }

}
