<?php

namespace MySecurity\App;

use MySecurity\OnrampMini\ServiceProvider\ServiceProviderBase;
use MySecurity\App\Feature;

/**
 * Class ServiceProvider
 */
final class ServiceProvider extends ServiceProviderBase
{
    /**
     *
     */
    public function init()
    {
        $this->build_plugin_info = [
            'description' => 'Modify wordpress security',
            'author'      => 'Onramp',
        ];
    }

    /**
     *
     */
    public function start()
    {
        //
        // check
        //
        if (! $this->execute(Feature\DependencyCheck\DependencyCheck::class)) {
            return false;
        }

        //
        // debug only
        //
        // $this->execute(Feature\ShowAllActions\ShowAllActions::class);
        // $this->execute(Feature\TestOnly\TestOnly::class);

        //
        // enable momentary to do
        //
        $this->execute(Feature\PluginEnableMessage\PluginEnableMessage::class);

        //
        // setting page
        //
        // $this->execute(Feature\CustomPage\CustomPage::class);   // 設定選項 獨立一個選項
        $this->execute(Feature\Settings\Settings::class);       // 設定選項 在 Settings 之下

        //
        // your business
        //
        $this->execute(Feature\RemoveWordpressInfo\RemoveWordpressInfo::class);

    }

}










