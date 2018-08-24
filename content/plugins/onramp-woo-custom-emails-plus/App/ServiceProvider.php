<?php

namespace Onramp_Woo_Custom_Emails_Plus\App;

use Onramp_Woo_Custom_Emails_Plus\App\Service\CheckService;
use Onramp_Woo_Custom_Emails_Plus\App\Service\DebugInfoService;
use Onramp_Woo_Custom_Emails_Plus\App\Service\ShowInfoService;
use Onramp_Woo_Custom_Emails_Plus\App\Core\Main;

/**
 * Class ServiceProvider
 */
final class ServiceProvider
{

    public function __construct(string $file)
    {
        $this->file = $file;
    }

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
