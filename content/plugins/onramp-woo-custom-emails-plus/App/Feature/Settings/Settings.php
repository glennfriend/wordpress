<?php

namespace OnrampWooCustomEmailsPlus\App\Feature\Settings;

use OnrampWooCustomEmailsPlus\OnrampMini\Core\Controller;

class Settings extends Controller
{
    /**
     *
     */
    public function perform()
    {
        //
        $defaultTab = SettingsGeneral::TAB;
        $this->tabs = [
            SettingsGeneral::TAB    => SettingsGeneral::class,
            SettingsDocument::TAB   => SettingsDocument::class,
        ];

        $this->menuName  = 'Onramp Set';
        $this->pageTitle = $this->provider->name;
        $this->pageId    = $this->provider->key . 'settings';
        $this->saveName  = null;    // save to database

        // wordpress form 的基本框架
        $this->tabFocus = $_GET['tab'] ?? $defaultTab;
        if (! array_key_exists($this->tabFocus, $this->tabs)) {
            $this->tabFocus = array_keys($this->tabs)[0];
        }
        add_action('admin_menu', [$this, 'settings_page']);


        // 每一頁 tab 的內容由一個 class 來管理, 並且有各自的儲存參數
        $className = $this->tabs[$this->tabFocus];
        $this->saveName = $this->provider->key . $this->tabFocus;
        $class = new $className($this->pageId, $this->saveName);
        add_action('admin_init', [$class, 'page']);


        // plugin setting links
        add_filter('plugin_action_links_' . plugin_basename($this->provider->file), [$this, 'plugin_action_links']);
    }

    /**
     * Adds plugin action links
     *
     * @return array
     */
    public function plugin_action_links($links)
    {
        $pageId = $this->pageId;
        $tab = $this->tabFocus;
        $settingLink = admin_url('admin.php?page=' . $pageId . '&tab=' . $tab);

        $pageId = $this->pageId;
        $docLink = admin_url('admin.php?page=' . $pageId . '&tab=document');

        $pluginLinks = [
            '<a href="' . $settingLink .    '">' . __('Settings')   . '</a>',
            '<a href="' . $docLink .        '">' . __('Doc')        . '</a>',
        ];
        return array_merge($pluginLinks, $links);
    }

    /**
     *
     */
    public function settings_page()
    {
        $title  = $this->pageTitle;
        $menu   = $this->menuName;
        $slug   = $this->pageId;

        add_submenu_page(
            'options-general.php',
            $title,
            $menu,
            "manage_options",
            $slug,
            [$this, 'settings_view']
        );
    }

    /**
     * Create the page
     */
    public function settings_view()
    {
        $views = [
            'tabs' => $this->tabs,
            'tabFocus' => $this->tabFocus,
        ];
        $this->view('settings', $views);
    }

}
