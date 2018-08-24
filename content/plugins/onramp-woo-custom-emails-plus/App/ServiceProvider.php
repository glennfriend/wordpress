<?php

namespace Onramp_Woo_Custom_Emails_Plus\App;

use Onramp_Woo_Custom_Emails_Plus\App\Template;

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
     * @param string $dir
     */
    public function __construct(string $file)
    {
        $this->file = $file;
        $this->dir = dirname($file);
        $this->helper = new WordpressPluginHelper($this->dir);
        $this->display = new WordpressDispaly();
    }

    public function init()
    {
        add_filter('wcemails_find_placeholders', [$this, 'wooCustomEmailsTemplatesPlus'], $this->priority, 2);

        add_action('init',           [$this, 'initHook'],               $this->priority );
        add_action('admin_init',     [$this, 'dependencyCheckHook'],    $this->priority );

        // for debug only
        // 在 debug mode 有啟用的情況, 通常會是在 staging 的環境之下
        if (WP_DEBUG && false) {
            add_action('shutdown', [$this, 'showAllActions'], $this->priority );
        }

        $this->activatePluginTrigger();
    }

    /**
     * 每次對 plugin 做 active 的時候, 會觸發一次
     */
    public function activatePluginTrigger()
    {
        $cacheName = $this->helper->getNamespace() . '_activate_plugin_trigger';

        register_activation_hook($this->file, function($key) use ($cacheName) {
            set_transient($key, true);
        });

        add_action('admin_notices', function($key) use ($cacheName) {
            if (get_transient($key)) {
                delete_transient($key);
                $this->showEnablePluginInfo();
            }
        });
    }

    // ================================================================================
    //  function hook
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

    // ================================================================================
    //
    // ================================================================================

    /**
     * 通常於 staging 使用
     * 如果要檢查操作的順序以及每個操作的觸發次數，那麼您可以使用
     */
    public function showAllActions()
    {
        $message = '<pre>' . print_r($GLOBALS['wp_actions'], true) . '</pre>';
        $this->display->info($message);
        $this->display->showAll();
    }

    /**
     *
     */
    public function showEnablePluginInfo()
    {
        $message = <<<"EOD"
priority = {$this->priority}
add new template to "<b>Woo Custom Emails</b>" plugin =
    {onramp_woo_custom_emails_plus_version}
    {onramp_woo_custom_emails_plus_order_itmes}
    {onramp_woo_custom_emails_plus_order_items_and_count}
    {onramp_woo_custom_emails_plus_order_total}
EOD;

        $this->display->info('<pre>' . $message . '</pre>');
        $this->display->showAll();
    }

}
