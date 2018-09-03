<?php

namespace OnrampWooCustomEmailsPlus\App\Feature\CustomPage;

use OnrampWooCustomEmailsPlus\App\ServiceProvider;

class CustomPage
{
    /**
     * @param ServiceProvider $serviceProvider
     */
    public function perform(ServiceProvider $serviceProvider)
    {
        $this->provider = $serviceProvider;
        $this->pageTitle = 'Onramp Set';
        $this->pageKey = $serviceProvider->key . 'page';

        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_init', [$this, 'free_1']);
    }

    // ================================================================================
    //  menu
    // ================================================================================

    /**
     * top level menu
     */
    public function menu()
    {
        // echo '<pre style="margin-left:200px;">';
        // print_R($this->provider);
        // echo '</pre>';

        $pageTitle = $this->provider->name;
        $this->optionName = $this->provider->key . 'setting';
        $this->capability = 'manage_options';

        // add top level menu page
        add_menu_page(
            $pageTitle,
            $this->pageTitle,
            $this->capability,
            $this->pageKey,
            [$this, 'CustomPageHtml']
        );
    }

    public function description($args)
    {
        echo 'title description.';
    }

    public function CustomPageHtml()
    {
        // check user capabilities
        if (! current_user_can($this->capability)) {
            return;
        }

        // add error/update messages
        // check if the user have submitted the settings
        // wordpress will add the "settings-updated" $_GET parameter to the url
        if (isset($_GET['settings-updated'])) {
            // add settings saved message with the class of "updated"
            add_settings_error('show_messages', 'show_message', __('Settings Saved', $this->pageKey), 'updated');
        }
        // show error/update messages
        settings_errors('show_messages');

        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields($this->pageKey);
                do_settings_sections($this->pageKey);
                submit_button('Save Settings');
                ?>
            </form>
        </div>
        <?php
    }


    // ================================================================================
    //  free 1
    // ================================================================================

    public function free_1() {

        $id = $this->provider->key . 'free_1';
        $title = __('Free1 Setting', $this->pageKey);
        $saveKey = 'free1';

        register_setting($this->pageKey, $this->optionName);

        add_settings_section(
            $id,
            __('Title', $this->pageKey ),
            [$this, 'description'],
            $this->pageKey
        );

        add_settings_field(
            $saveKey,
            $title,
            [$this, 'free_1_options'],
            $this->pageKey,
            $id,
            [
                'label_for' => $saveKey,
                'class' => 'wporg_row',
                'wporg_custom_data' => 'custom',
            ]
        );
    }

    public function free_1_options( $args )
    {
        // from database
        $options = get_option($this->optionName);

        // echo '<pre style="margin-left:200px;">';
        // print_R($options);
        // echo '</pre>';

        $id = esc_attr($args['label_for']);
        $data = $args['wporg_custom_data'];
        $name = "{$this->optionName}[{$id}]";
        $items = [
            'red'    => 'Red Option',
            'green'  => 'Green Option',
            'yellow' => 'Yellow Option',
        ];

        echo  <<<"EOD"
            <select id="{$id}" data-custom="{$data}" name="{$name}">
EOD;

        foreach ($items as $key => $show) {
            $focus = null;
            if (isset($options[$args['label_for']])) {
                $focus = selected($options[$args['label_for']], $key, false);
            }

            echo '<option value="'. $key .'" '. $focus.'>';
            echo esc_html_e($show, $this->pageKey);
            echo '</option>';
            echo "\n";
        }

        echo '</select>';
        echo '<p class="description">Free1 Description</p>';
    }


}