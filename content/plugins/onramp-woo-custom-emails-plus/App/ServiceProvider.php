<?php

namespace OnrampWooCustomEmailsPlus\App;

use OnrampWooCustomEmailsPlus\OnrampMini\ServiceProvider\ServiceProviderBase;
use OnrampWooCustomEmailsPlus\App\Service\CheckService;
use OnrampWooCustomEmailsPlus\App\Service\DebugInfoService;
use OnrampWooCustomEmailsPlus\App\Service\ShowInfoService;
use OnrampWooCustomEmailsPlus\App\Core\Main;

/**
 * Class ServiceProvider
 */
final class ServiceProvider extends ServiceProviderBase
{

    public function init()
    {
        $main = new Main();
        $priority = $main->get('priority');
        $adminInfo = $main->get('admin_info');

        //
        $showInfoService = new ShowInfoService($this->file, $priority);
        $showInfoService->perform($adminInfo);

        $checkService = new CheckService();
        $checkService->perform();

        // for debug only
        if (WP_DEBUG && false) {
            // 在 debug mode 有啟用的情況, 通常會是在 staging 的環境之下
            $debugInfoService = new DebugInfoService();
            $debugInfoService->perform();
        }

        //
        $main->start();
    }

}
