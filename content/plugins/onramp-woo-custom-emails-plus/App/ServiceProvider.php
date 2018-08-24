<?php

namespace Onramp_Woo_Custom_Emails_Plus\App;

use Onramp_Woo_Custom_Emails_Plus\App\Template;
use Onramp_Woo_Custom_Emails_Plus\App\Service\CheckService;
use Onramp_Woo_Custom_Emails_Plus\App\Service\DebugInfoService;
use Onramp_Woo_Custom_Emails_Plus\App\Service\ShowInfoService;

/**
 * Class ServiceProvider
 */
final class ServiceProvider
{
    /**
     * @var int
     */
    protected $priority = 1000;

    /**
     *
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function workBeforehand()
    {
        $showInfoService = new ShowInfoService($this->file, $this->priority);
        $showInfoService->perform();

        $checkService = new CheckService();
        $checkService->perform();

        // for debug only
        if (WP_DEBUG && false) {
            // 在 debug mode 有啟用的情況, 通常會是在 staging 的環境之下
            $debugInfoService = new DebugInfoService();
            $debugInfoService->perform();
        }
    }

    // ================================================================================
    //
    // ================================================================================

    public function init()
    {
        $this->workBeforehand();
        add_filter('wcemails_find_placeholders', [$this, 'wooCustomEmailsTemplatesPlus'], $this->priority, 2);
    }

    /**
     * 幫助 "Woo Custom Emails" plugin 加上更多的 template variables
     *
     * @param $placeholders
     * @param $object
     * @return mixed
     */
    public function wooCustomEmailsTemplatesPlus($placeholders, $object)
    {
        if (! isset($placeholders['{site_title}'])) {
            // Don't do anything
            // plugin 有 先後順序 & 資料變動 的問題
            // 即使這個時間點沒問題, 不代表未來的某一天也會是正常的
            return $placeholders;
        }

        $placeholders['{onramp_woo_custom_emails_plus_version}'] = '1.0';

        $template = new Template\OrderItems($object);
        $placeholders['{onramp_woo_custom_emails_plus_order_itmes}'] = $template->render();

        $template = new Template\OrderItemsAndCount($object);
        $placeholders['{onramp_woo_custom_emails_plus_order_items_and_count}'] = $template->render();

        $template = new Template\OrderTotal($object);
        $placeholders['{onramp_woo_custom_emails_plus_order_total}'] = $template->render();


        return $placeholders;
    }

}
