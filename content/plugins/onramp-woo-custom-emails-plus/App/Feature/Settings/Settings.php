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

        //
        $this->tabFocus = $_GET['tab'] ?? $defaultTab;
        if (! array_key_exists($this->tabFocus, $this->tabs)) {
            $this->tabFocus = array_keys($this->tabs)[0];
        }

        add_action('admin_menu', [$this, 'settings_page']);


        //
        $className = $this->tabs[$this->tabFocus];
        $this->saveName = $this->provider->key . $this->tabFocus;
        $class = new $className($this->pageId, $this->saveName);

        add_action('admin_init', [$class, 'page']);
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
