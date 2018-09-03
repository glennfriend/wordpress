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
        //
    }

    /**
     *
     */
    public function start()
    {
        // debug only
        // $this->execute(Feature\ShowAllActions\ShowAllActions::class);
        // $this->execute(Feature\TestOnly\TestOnly::class);

        // basic, you can disable
        $this->execute(Feature\DependencyCheck\DependencyCheck::class);
        $this->execute(Feature\PluginEnableMessage\PluginEnableMessage::class);
        $this->execute(Feature\CustomPage\CustomPage::class);

        // your business
        $this->execute(Feature\EmailTemplatePlus\EmailTemplatePlus::class);

    }

}










