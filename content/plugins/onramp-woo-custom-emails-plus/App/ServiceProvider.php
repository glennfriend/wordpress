<?php

namespace OnrampWooCustomEmailsPlus\App;

use OnrampWooCustomEmailsPlus\OnrampMini\ServiceProvider\ServiceProviderBase;
use OnrampWooCustomEmailsPlus\App\Feature;

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
            'description' => 'Add some email template variables. Dependency by "Woo Custom Emails" v2.2',
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
        $this->execute(Feature\EmailTemplatePlus\EmailTemplatePlus::class);

    }

}










