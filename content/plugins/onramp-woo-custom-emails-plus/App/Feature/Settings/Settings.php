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
        $this->menuName = 'Onramp Set';
        $this->pageTitle = $this->provider->name;
        $this->pageId    = $this->provider->key . 'settings';
        $this->saveName = $this->provider->key . 'general';  // to database

        add_action('admin_menu', array( $this, 'settings_page' ) );
        add_action('admin_init', array( $this, 'setup_init' ) );
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
        $tabs = [
            'general' => 'General',
            'document' => 'Document',
        ];

        $tabFocus = $_GET['tab'] ?? 'general';
        if (! array_key_exists($tabFocus, $tabs)) {
            $tabFocus = array_keys($tabs)[0];
        }

        $views = [
            'tabs' => $tabs,
            'tabFocus' => $tabFocus,
        ];
        $this->view('settings', $views);
    }

    public function setup_init()
    {
        $title = null;
        register_setting($this->pageId, $this->saveName);
        add_settings_section($this->pageId, $title, [$this, 'top_section'], $this->saveName);

        // TODO: 沒有做 進入 options.php 的 filter & check
        $this->field_number();
        $this->field_login_url();
        $this->field_color();
        $this->show_bar();
    }

    /**
     * @param $arguments
     */
    public function top_section($arguments)
    {
        $isDebug = false;

        if ($isDebug) {
            echo '<pre>';
            print_r($arguments);
            echo '</pre>';
        }
    }

    // ================================================================================
    //  input fields
    // ================================================================================

    /**
     *
     */
    public function field_number()
    {
        $func = function($name)
        {
            $options = get_option($this->saveName);
            $field = "{$this->saveName}[{$name}]";
            $value = $options[$name];
            echo <<<"EOD"
                <input name="{$field}" type="text" value="{$value}">
EOD;
        };

        $title = 'My Number';
        $fieldName = "number";
        add_settings_field($fieldName, $title, $func, $this->saveName, $this->pageId, $fieldName);
    }

    /**
     *
     */
    public function field_login_url()
    {
        $func = function($name)
        {
            $options = get_option($this->saveName);
            $field = "{$this->saveName}[{$name}]";
            $value = $options[$name];
            echo <<<"EOD"
                <input name="{$field}" type="text" value="{$value}">
EOD;
        };

        $title = 'Login Url';
        $fieldName = "login_url";
        add_settings_field($fieldName, $title, $func, $this->saveName, $this->pageId, $fieldName);
    }

    /**
     *
     */
    function field_color()
    {
        $func = function($name)
        {
            $items = [
                'red'    => 'Red Option',
                'green'  => 'Green Option',
                'yellow' => 'Yellow Option',
            ];

            $options = get_option($this->saveName);
            $field = "{$this->saveName}[{$name}]";
            $value = $options[$name];

            echo '<select name="' . $field .'">';

            foreach ($items as $key => $show) {
                $focus = null;
                if ($key === $value) {
                    $focus = selected($options[$name], $key, false);
                }

                echo '<option value="'. $key .'" '. $focus.'>';
                echo    esc_html_e($show, $this->pageId);
                echo '</option>';
                echo "\n";
            }

            echo '</select>';
            echo '<p class="description">Color Options</p>';

        };

        $title = 'My Color';
        $fieldName = "color";
        add_settings_field($fieldName, $title, $func, $this->saveName, $this->pageId, $fieldName);
    }

    /**
     *
     */
    public function show_bar()
    {
        $func = function()
        {
            echo '<hr style="margin-top:7px; *margin: 0; border: 0; color: black; background-color: black; height: 1px">';
        };

        add_settings_field(uniqid(), null, $func, $this->saveName, $this->pageId, null);
    }


}
