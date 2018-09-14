<?php

namespace OnrampWooCustomEmailsPlus\App\Feature\Settings;

class SettingsDescription
{

    const TAB = 'description';
    const LABEL = 'Description';
    const SHOW_SUBMIT = true;

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
        register_setting($this->pageId, $this->saveName);
        add_settings_section($this->pageId, $title, [$this, 'top_section'], $this->saveName);

        $this->field_number();
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
            $value = isset($options[$name]) ? $options[$name] : 'default';

            echo <<<"EOD"
                <input name="{$field}" type="text" value="{$value}">
EOD;
        };

        $title = 'My Number';
        $fieldName = "number";
        add_settings_field($fieldName, $title, $func, $this->saveName, $this->pageId, $fieldName);
    }

}
