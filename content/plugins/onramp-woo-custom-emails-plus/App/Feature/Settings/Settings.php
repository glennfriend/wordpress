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
        $this->pageTitle = 'Onramp Set';
        $this->pageId = $this->provider->key . 'settings';
        $this->menuId = $this->provider->key . 'settings_menu';
        //$this->provider = $provider;

        add_action('init', [$this, 'set_up_menu']);
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

            echo '<pre style="margin-left:200px;">111</pre>';

            add_action('admin_menu', [$this, 'add_settings_menu']);

            // Add SendGrid settings page in the plugin list
            //add_filter( 'plugin_action_links_' . self::$plugin_directory, array( __CLASS__, 'add_settings_link' ) );

        } elseif ( is_multisite() and is_main_site() ) {

            echo '<pre style="margin-left:200px;">222</pre>';

            // Add SendGrid settings page in the network admin menu
            //add_action( 'network_admin_menu', array( __CLASS__, 'add_network_settings_menu' ) );

        }
        else {

            echo '<pre style="margin-left:200px;">333</pre>';

        }
        // Add SendGrid Help contextual menu in the settings page
        //add_filter( 'contextual_help', array( __CLASS__, 'show_contextual_help' ), 10, 3 );

        // Add SendGrid javascripts in header
        // add_action( 'admin_enqueue_scripts', array( __CLASS__, 'add_headers' ) );

    }

    /**
     * Add settings page in the menu
     *
     * @return void
     */
    public function add_settings_menu()
    {
        add_options_page(
            __($this->pageTitle),
            __($this->pageTitle),
            'manage_options',
            $this->pageId,
            [$this, 'show_settings_page']
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




















    public function description($args)
    {
        echo 'title description.';
    }

    public function CustomPageHtml()
    {
        if (! current_user_can($this->capability)) {
            return;
        }

        //
        if (isset($_GET['settings-updated'])) {
            add_settings_error('show_messages', 'show_message', __('Settings Saved', $this->pageId), 'updated');
        }
        // show error/update messages
        settings_errors('show_messages');

        //
        $this->showForm();


    }

    protected function showForm()
    {
        $title = esc_html(get_admin_page_title());

        echo '<div class="wrap">';
        echo "    <h1>{$title}</h1>";
        echo '    <form action="options.php" method="post">';

        settings_fields($this->pageId);
        do_settings_sections($this->pageId);
        submit_button('Save Settings');

        echo '    </form>';
        echo '</div>';
    }

    protected function registerSetting()
    {
        register_setting($this->pageId, $this->optionName);

        add_settings_section(
            $this->menuId,
            __('Title', $this->pageId),
            [$this, 'description'],
            $this->pageId
        );
    }

    // ================================================================================
    //  free 1
    // ================================================================================

    public function free_1()
    {
        $this->registerSetting();

        $title = __('Free1 Setting', $this->pageId);
        $saveKey = 'free1';

        add_settings_field(
            $saveKey,
            $title,
            [$this, 'free_1_options'],
            $this->pageId,
            $this->menuId,
            [
                'label_for' => $saveKey,
                'data_custom' => 'custom',
                // 'class' => 'your_class_name', // 如果你要自定義自己的 class name
            ]
        );
    }

    public function free_1_options($args)
    {
        $options = get_option($this->optionName);

        // echo '<pre style="margin-left:200px;">';
        // print_R($options);
        // echo '</pre>';

        $labelFor = $args['label_for'];
        $id = esc_attr($labelFor);
        $data = $args['data_custom'];
        $name = "{$this->optionName}[{$id}]";
        $items = [
            'red'    => 'Red Option',
            'green'  => 'Green Option',
            'yellow' => 'Yellow Option',
        ];

        echo  <<<"EOD"
            <select id="{$id}" data-custom="{$data}" name="{$name}">
EOD;

        foreach ($items as $value => $show) {
            $focus = null;
            if (isset($options[$labelFor])) {
                $focus = selected($options[$labelFor], $value, false);
            }

            echo '<option value="'. $value .'" '. $focus.'>';
            echo    esc_html_e($show, $this->pageId);
            echo '</option>';
            echo "\n";
        }

        echo  <<<"EOD"
            </select>
            <p class="description">Free1 Description</p>
EOD;

    }

}
