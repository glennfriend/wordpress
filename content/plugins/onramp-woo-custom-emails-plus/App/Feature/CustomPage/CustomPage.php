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
        $this->menuId = $this->provider->key . 'menu';

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
        $this->optionName = $this->provider->key . 'config';   // from database
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
        if (! current_user_can($this->capability)) {
            return;
        }

        //
        if (isset($_GET['settings-updated'])) {
            add_settings_error('show_messages', 'show_message', __('Settings Saved', $this->pageKey), 'updated');
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

        settings_fields($this->pageKey);
        do_settings_sections($this->pageKey);
        submit_button('Save Settings');

        echo '    </form>';
        echo '</div>';
    }

    protected function registerSetting()
    {
        register_setting($this->pageKey, $this->optionName);

        add_settings_section(
            $this->menuId,
            __('Title', $this->pageKey),
            [$this, 'description'],
            $this->pageKey
        );
    }

    // ================================================================================
    //  free 1
    // ================================================================================

    public function free_1()
    {
        $this->registerSetting();

        $title = __('Free1 Setting', $this->pageKey);
        $saveKey = 'free1';

        add_settings_field(
            $saveKey,
            $title,
            [$this, 'free_1_options'],
            $this->pageKey,
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

        foreach ($items as $key => $show) {
            $focus = null;
            if (isset($options[$labelFor])) {
                $focus = selected($options[$labelFor], $key, false);
            }

            echo '<option value="'. $key .'" '. $focus.'>';
            echo    esc_html_e($show, $this->pageKey);
            echo '</option>';
            echo "\n";
        }

        echo '</select>';
        echo '<p class="description">Free1 Description</p>';
    }

}
