<?php

namespace OnrampWooCustomEmailsPlus\OnrampMini\Lib;

/**
 * Class WordpressPluginHelper
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

    public function getNamespace()
    {
        return explode("\\", __NAMESPACE__)[0];
    }


    /*
    public function define($name, $value) {
        if (! defined($name) ) {
            define($name, $value);
        }
    }
    */

}
