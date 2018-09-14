<?php

namespace MySecurity\App\Feature\Settings;

use MySecurity\App\Feature;

class SettingsGeneral
{

    const TAB = 'general';
    const LABEL = 'General';

    /**
     * @param $pageId
     * @param $saveName
     */
    public function __construct($pageId, $saveName)
    {
        $this->pageId = $pageId;
        $this->saveName = $saveName;
    }

    /**
     *
     */
    public function page()
    {
        $title = null;
        add_settings_section($this->pageId, $title, [$this, 'top_section'], $this->saveName);
    }

    /**
     *
     */
    public function top_section()
    {
        echo Feature\RemoveWordpressInfo\RemoveWordpressInfo::getDescription();
    }

}
