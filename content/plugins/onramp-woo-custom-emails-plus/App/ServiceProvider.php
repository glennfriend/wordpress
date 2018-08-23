<?php

namespace Onramp_Woo_Custom_Emails_Plus\App;

use Onramp_Woo_Custom_Emails_Plus\App\Template\Price;

/**
 * Class ServiceProvider
 */
final class ServiceProvider
{

    public function __construct(string $dir)
    {
        $this->dir = $dir;
        $this->helper = new WordpressPluginHelper($dir);
    }

    public function init()
    {
        add_action('init', [$this, 'wordpress_init']);
    }

    public function wordpress_init()
    {
        $price = new Price();
        $value = $price->getValue();

        if (WP_DEBUG) {
            $message = [];
            $message[] = '[Onramp_Woo_Custom_Emails_Plus]';
            $message[] = 'hello world init!' . $value;
            $message[] = 'pluginPath = ' . $this->helper->pluginPath();
            echo '<div class="notice notice-success"><p>' . join("<br>\n", $message) .'</p></div>';
        }
    }

    // ================================================================================
    //  private
    // ================================================================================


}
