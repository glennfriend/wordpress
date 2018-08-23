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
        $isDebugMode = WP_DEBUG;

        $this->dir = $dir;
        $this->helper = new WordpressPluginHelper($dir);
        $this->display = new WordpressDispaly($isDebugMode);
    }

    public function init()
    {
        add_action('plugins_loaded', [$this, 'debugModeHook']);
        add_action('init',           [$this, 'initHook']);
        add_action('admin_init',     [$this, 'dependencyCheckHook']);
    }

    // ================================================================================
    //  hook
    // ================================================================================

    public function initHook()
    {
    }

    public function debugModeHook()
    {
        if (! WP_DEBUG) {
            return;
        }

        $price = new Price();
        $value = $price->getValue();

        $this->display->success('hello world init!' . $value);
        $this->display->success('pluginPath = ' . $this->helper->pluginPath());
        $this->display->showAll();

        // 如果要檢查操作的順序以及每個操作的觸發次數，那麼您可以使用
        if (false) {
            add_action('shutdown', function () {
                $message = '<pre>' . print_r($GLOBALS['wp_actions'], true) . '</pre>';
                $this->display->info($message);
                $this->display->showAll();
            });
        }

    }

    public function dependencyCheckHook()
    {
        if (! is_plugin_active('woo-custom-emails/woo-custom-emails.php')) {
            $this->display->error('<b>woo-custom-emails</b> plugin not exists!');
            $this->display->showAll();
        }
    }

    // ================================================================================
    //  private
    // ================================================================================

}
