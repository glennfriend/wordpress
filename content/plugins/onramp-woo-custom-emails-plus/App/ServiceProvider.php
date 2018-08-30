<?php

namespace OnrampWooCustomEmailsPlus\App;

use OnrampWooCustomEmailsPlus\OnrampMini\ServiceProvider\ServiceProviderBase;
//
use OnrampWooCustomEmailsPlus\App\Feature\ShowAllActions\ShowAllActions;
use OnrampWooCustomEmailsPlus\App\Feature\PluginEnableMessage\PluginEnableMessage;
use OnrampWooCustomEmailsPlus\App\Feature\DependencyCheck\DependencyCheck;
use OnrampWooCustomEmailsPlus\App\Feature\TestOnly\TestOnly;
//
use OnrampWooCustomEmailsPlus\App\Feature\EmailTemplatePlus\EmailTemplatePlus;


/**
 * Class ServiceProvider
 */
final class ServiceProvider extends ServiceProviderBase
{

    public function start()
    {
        // debug only, you can disable
        // $this->execute(ShowAllActions::class);
        // $this->execute(TestOnly::class);

        // basic, you can disable
        $this->execute(DependencyCheck::class);
        $this->execute(PluginEnableMessage::class);

        // your business
        $this->execute(EmailTemplatePlus::class);
    }


}
