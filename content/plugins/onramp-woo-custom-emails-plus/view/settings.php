<?php

    $displayNav = function() use ($tabs, $tabFocus)
    {
        $title = esc_html(get_admin_page_title());
        $pageId = $this->pageId;

        echo '<h2>' . $title . '</h2>';
        echo '<h2 class="nav-tab-wrapper sengrid-settings-nav-bar">';
        foreach ($tabs as $tab => $className) {
            $focus = null;
            if ($tabFocus === $tab) {
                $focus = 'nav-tab-active';
            }

            $show = $className::LABEL;
            echo '<a href="?page='. $pageId . '&tab='. $tab .'" class="nav-tab ' . $focus . '">' . $show . '</a>';
        }
        echo '</h2>';
    };

    $displayForm = function() use ($tabFocus)
    {
        $action = "options.php?tab=" . $tabFocus;
        echo '<form method="post" action="'. $action .'">';
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
        // $dispalyDebug();
    echo '</div>';
