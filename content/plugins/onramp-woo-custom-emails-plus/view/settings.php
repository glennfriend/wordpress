<?php

    $displayNav = function() use ($tabs, $tabFocus)
    {
        $pageId = $this->pageId;

        echo '<h2 class="nav-tab-wrapper sengrid-settings-nav-bar">';
        foreach ($tabs as $tab => $show) {
            $focus = null;
            if ($tabFocus === $tab) {
                $focus = 'nav-tab-active';
            }
            echo '<a href="?page='. $pageId . '&tab='. $tab .'" class="nav-tab ' . $focus . '">' . $show . '</a>';
        }
        echo '</h2>';
    };

    $displayForm = function()
    {
        $title = esc_html(get_admin_page_title());

        echo '<h2>' . $title . '</h2>';
        echo '<form method="post" action="options.php">';

        settings_fields($this->pageId);
        do_settings_sections($this->saveName);
        submit_button();

        echo '</form>';
    };

    $dispalyDebug = function() use ($views)
    {
        echo '<pre>';
        print_r($this);
        print_r($views);
        echo '</pre>';
    };




    echo '<div class="wrap">';
        $displayNav();
        $displayForm();
        $dispalyDebug();
    echo '</div>';
