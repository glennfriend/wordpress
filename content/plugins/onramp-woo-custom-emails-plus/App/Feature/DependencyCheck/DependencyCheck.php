<?php

namespace OnrampWooCustomEmailsPlus\App\Feature\DependencyCheck;

use OnrampWooCustomEmailsPlus\App\ServiceProvider;
use OnrampWooCustomEmailsPlus\OnrampMini\Lib\WordpressDispaly;

class DependencyCheck
{

    public function perform(ServiceProvider $provider)
    {
        $this->display = new WordpressDispaly();

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