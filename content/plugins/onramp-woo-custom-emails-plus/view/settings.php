<?php

    $displayNav = function($tabs, $tabFocus)
    {
        $pageId = $this->pageId;

        echo '<h2>' . getTitle() . '</h2>';
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

    $displayForm = function($tabFocus, $showSubmit)
    {
        $action = "options.php?tab=" . $tabFocus;
        echo '<form method="post" action="'. $action .'">';

        settings_fields($this->pageId);
        do_settings_sections($this->saveName);

        if ($showSubmit) {
            submit_button();
        }

        echo '</form>';
    };

    $dispalyDebug = function() use ($views)
    {
        echo '<pre>';
        print_r($this);
        print_r($views);
        echo '</pre>';
    };




    //
    $className = getFocusTabClass($tabs, $tabFocus);
    $showSubmit = $className::SHOW_SUBMIT;

    echo '<div class="wrap">';
        $displayNav($tabs, $tabFocus);
        $displayForm($tabFocus, $showSubmit);
        // $dispalyDebug();
    echo '</div>';








    // ================================================================================
    //  functions
    // ================================================================================

    function getFocusTabClass(array $tabs, $tabFocus)
    {
        foreach ($tabs as $tab => $className) {
            $focus = null;
            if ($tabFocus === $tab) {
                return $className;
            }
        }

        return null;
    }

    function getTitle()
    {
        return esc_html(get_admin_page_title());
    }
