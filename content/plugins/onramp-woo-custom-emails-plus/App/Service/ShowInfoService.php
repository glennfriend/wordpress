<?php

namespace Onramp_Woo_Custom_Emails_Plus\App\Service;

use Onramp_Woo_Custom_Emails_Plus\App\WordpressDispaly;
use Onramp_Woo_Custom_Emails_Plus\App\WordpressPluginHelper;


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

    public function perform()
    {
        $this->activatePluginTrigger();
    }

    /**
     * 每次對 plugin 做 active 的時候, 會觸發一次
     */
    public function activatePluginTrigger()
    {
        $cacheName = $this->helper->getNamespace() . '_activate_plugin_trigger';

        register_activation_hook($this->file, function($key) use ($cacheName) {
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
     *
     */
    public function showEnablePluginInfo()
    {
        $message = <<<"EOD"
<pre>priority = {$this->priority}
add new template to "<b>Woo Custom Emails</b>" plugin =
    {onramp_woo_custom_emails_plus_version}
    {onramp_woo_custom_emails_plus_order_itmes}
    {onramp_woo_custom_emails_plus_order_items_and_count}
    {onramp_woo_custom_emails_plus_order_total}
</pre>
EOD;

        $this->display->info($message);
        $this->display->showAll();
    }

}
