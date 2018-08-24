<?php

namespace Onramp_Woo_Custom_Emails_Plus\App\Service;

use Onramp_Woo_Custom_Emails_Plus\App\WordpressDispaly;

/**
 * Class DependencyCheckService
 */
final class CheckService
{

    public function __construct()
    {
        $this->display = new WordpressDispaly();
    }

    public function perform()
    {
        add_action('admin_init', [$this, 'dependencyPluginCheck']);
        add_action('admin_init', [$this, 'phpVersionCheck']);
    }

    /**
     * 該 plugin 必須 dependency 特定的 plugin
     */
    public function dependencyPluginCheck()
    {
        if (! is_plugin_active('woo-custom-emails/woo-custom-emails.php')) {
            $this->display->error('<b>woo-custom-emails</b> plugin not exists!');
            $this->display->showAll();
        }
    }

    /**
     * php version check
     */
    public function phpVersionCheck()
    {
        $phpVersionDefine = '5.6.0';
        if (version_compare(phpversion(), $phpVersionDefine, '<')) {
            $this->display->error("Plugin requires PHP >= {$phpVersionDefine}");
            $this->display->showAll();
        }
    }

}
