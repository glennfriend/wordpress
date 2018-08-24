<?php

namespace Onramp_Woo_Custom_Emails_Plus\App;

use Onramp_Woo_Custom_Emails_Plus\App\Template;

/**
 * Class ServiceProvider
 */
final class ServiceProvider
{
    protected $priority = 1000;

    /**
     * @param string $dir
     */
    public function __construct(string $dir)
    {
        $this->dir = $dir;
        $this->helper = new WordpressPluginHelper($dir);
        $this->display = new WordpressDispaly();
    }

    public function init()
    {
        add_action('plugins_loaded', [$this, 'debugModeHook'],          $this->priority );
        add_action('init',           [$this, 'initHook'],               $this->priority );
        add_action('admin_init',     [$this, 'dependencyCheckHook'],    $this->priority );

        add_filter('wcemails_find_placeholders', [$this, 'wooCustomEmailsTemplatesPlus'], $this->priority, 2);
    }

    // ================================================================================
    //  hook
    // ================================================================================

    /**
     * 該 plugin 必須 dependency 特定的 plugin
     */
    public function dependencyCheckHook()
    {
        if (! is_plugin_active('woo-custom-emails/woo-custom-emails.php')) {
            $this->display->error('<b>woo-custom-emails</b> plugin not exists!');
            $this->display->showAll();
        }

        $phpVersionDefine = '5.6.0';
        if (version_compare(phpversion(), $phpVersionDefine, '<')) {
            $this->display->error("Plugin requires PHP >= {$phpVersionDefine}");
            $this->display->showAll();
            return;
        }
    }

    public function initHook()
    {

    }

    /**
     * 在 debug mode 有啟用的情況, 通常會是在 staging 的環境之下
     */
    public function debugModeHook()
    {
        if (! WP_DEBUG) {
            return;
        }

        $this->display->info('priority = ' . $this->priority);
        // $this->display->info('pluginPath = ' . $this->helper->pluginPath());
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

        if (false) {
            $content = "================ \n";
            $content .= print_r($object, true);
            file_put_contents( __DIR__ . '/tmp.log', $content."\n", FILE_APPEND );
        }

        return $placeholders;
    }

    // ================================================================================
    //  private
    // ================================================================================

}
