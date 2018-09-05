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
        $this->menuId    = $this->provider->key . 'settings_menu';
        $this->saveName = $this->provider->key . 'general';  // to database

        // add_action('init',       [$this, 'set_up_menu']);
        //add_action('admin_menu', [$this, 'add_settings_menu']);
        //add_action('admin_init', [$this, 'crunchify_hello_world_settings']);
        //add_filter('the_content', [$this, 'crunchify_com_content']);

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
            [$this, 'settings_page_content']
        );
    }

    /**
     * Create the page
     */
    public function settings_page_content()
    {
        echo '<div class="wrap">';
        echo '    <h2>' . $this->pageTitle . '</h2>';
        echo '    <form method="post" action="options.php">';

        settings_fields($this->pageId);
        do_settings_sections($this->saveName);
        submit_button();

        echo '    </form>';
        echo '</div>';
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
            print_R($arguments);
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
     * @param $arguments
     */
    public function show_bar()
    {
        $func = function()
        {
            echo '<hr style="margin-top:7px; *margin: 0; border: 0; color: black; background-color: black; height: 1px">';
        };

        add_settings_field(uniqid(), null, $func, $this->saveName, $this->pageId, null);
    }











    // ================================================================================
    //  menu
    // ================================================================================

    /**
     * top level menu
     */
    public function set_up_menu()
    {
        // echo '<pre style="margin-left:200px;">';
        // print_R($this->provider);
        // echo '</pre>';

        if ((! is_multisite() and current_user_can('manage_options')) || (is_multisite() and ! is_main_site() and get_option($this->pageId)) ) {

            // echo '<pre style="margin-left:200px;">111</pre>';

            add_action('admin_menu', [$this, 'add_settings_menu']);

            // Add settings page in the plugin list

        } elseif ( is_multisite() and is_main_site() ) {

            // echo '<pre style="margin-left:200px;">222</pre>';

            // Add settings page in the network admin menu

        }
        else {

            // echo '<pre style="margin-left:200px;">333</pre>';

        }

        // Add Help contextual menu in the settings page
        //add_filter( 'contextual_help', array( __CLASS__, 'show_contextual_help' ), 10, 3 );

        // Add javascripts in header
        // add_action( 'admin_enqueue_scripts', array( __CLASS__, 'add_headers' ) );

    }

    /**
     * Add settings page in the menu
     *
     * @return void
     */
    public function add_settings_menu()
    {
        /*
        add_options_page(
            __($this->pageTitle),
            __($this->pageTitle),
            'manage_options',
            $this->pageId,
            [$this, 'show_settings_page']
        );
        */

        add_submenu_page(
            "options-general.php",
            $this->pageTitle,
            $this->pageTitle,
            "manage_options",
            $this->pageId,
            [$this, "show_settings_page"]
        );
    }

    /**
     * Display settings page content
     *
     * @return void
     */
    public function show_settings_page()
    {
        $response = null;
        $error_from_update = false;

        /*
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] and ! isset( $_POST['sg_dismiss_widget_notice'] ) ) {
            $response = self::do_post( $_POST );
            if ( isset( $response['status'] ) and $response['status'] == 'error' ) {
                $error_from_update = true;
            }
        }
        */

        $views = [
            'status' => 111,
            'message' => '222',
        ];
        $this->view('settings', $views);
    }



}
