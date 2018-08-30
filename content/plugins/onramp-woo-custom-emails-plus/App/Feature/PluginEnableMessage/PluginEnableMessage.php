<?php

namespace OnrampWooCustomEmailsPlus\App\Feature\PluginEnableMessage;

use OnrampWooCustomEmailsPlus\App\ServiceProvider;
use OnrampWooCustomEmailsPlus\OnrampMini\Lib\WordpressDispaly;
use OnrampWooCustomEmailsPlus\OnrampMini\Lib\WordpressPluginHelper;


class PluginEnableMessage
{

    public function perform(ServiceProvider $provider)
    {
        $file = $provider->file;
        $this->display = new WordpressDispaly();
        $this->helper = new WordpressPluginHelper(dirname($provider->file));

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
<pre>    add new template to "<b>Woo Custom Emails</b>" plugin:
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
