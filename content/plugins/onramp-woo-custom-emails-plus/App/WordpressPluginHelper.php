<?php

namespace Onramp_Woo_Custom_Emails_Plus\App;

/**
 * Class WordpressPluginHelper
 * @package Onramp_Woo_Custom_Emails_Plus\App
 */
final class WordpressPluginHelper
{

    /**
     * @param string $dir
     */
    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    /**
     * @return string
     */
    public function pluginPath(): string
    {
        return $this->dir;
    }

    /*
    public function define($name, $value) {
        if (! defined($name) ) {
            define($name, $value);
        }
    }
    */

}
