<?php

namespace Onramp_Woo_Custom_Emails_Plus\App;

use Onramp_Woo_Custom_Emails_Plus\App\Template\Price;

/**
 * Class ServiceProvider
 */
final class ServiceProvider
{
    /**
     * @param string $dir
     */
    public function __construct(string $dir)
    {
        $this->dir = $dir;
        $this->helper = new WordpressPluginHelper($dir);
    }

    public function init()
    {
        add_action('plugins_loaded', [$this, 'pluginsLoadedHook']);
        add_action('init',           [$this, 'initHook']);
    }

    // ================================================================================
    //  hook
    // ================================================================================

    public function initHook()
    {
    }

    public function pluginsLoadedHook()
    {
        add_action('admin_init', [$this, 'dependencyCheck']);

        $price = new Price();
        $value = $price->getValue();

        if (WP_DEBUG) {
            $message = [];
            $message[] = $this->getNamespaceShow() . ' [debug mode]';
            $message[] = 'hello world init!' . $value;
            $message[] = 'pluginPath = ' . $this->helper->pluginPath();
            echo '<div class="notice notice-success"><p>' . join("<br>\n", $message) .'</p></div>';
        }
    }

    // ================================================================================
    //  private
    // ================================================================================

    public function dependencyCheck()
    {
        if (! is_plugin_active('woo-custom-emails/woo-custom-emails.ph_p')) {
            $error = [];
            $error[] = $this->getNamespaceShow();
            $error[] = '<b>woo-custom-emails</b> plugin not exists!';
            echo '<div class="notice notice-error"><p>' . join("<br>\n", $error) .'</p></div>';
        }
    }

    protected function getNamespaceShow()
    {
        return '[' . $this->getNamespace() . ']';
    }

    protected function getNamespace()
    {
        return explode("\\", __NAMESPACE__)[0];
    }

}
