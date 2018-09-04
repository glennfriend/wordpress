<?php

namespace OnrampWooCustomEmailsPlus\OnrampMini\Core;

use Exception;
use OnrampWooCustomEmailsPlus\App\ServiceProvider;

/**
 * Class Controller
 */
class Controller
{
    /**
     * @param ServiceProvider $serviceProvider
     */
    public function __construct(ServiceProvider $serviceProvider)
    {
        $this->provider = $serviceProvider;
    }

    /**
     *
     */
    public function perform()
    {
        // please rewrite
        return true;
    }

    /**
     * @param string $name
     * @param array $params
     * @throws Exception
     */
    public function view(string $name, Array $params)
    {
        $file = dirname($this->provider->file) . '/view/' . $name . '.php';
        if (! file_exists($file)) {
            throw new Exception('view file not exists: "' . $file . '"');
        }

        //
        $includeView = function($includeViewFile, $views)
        {
            extract($views);
            include $includeViewFile;
        };
        $includeView($file, $params);
    }

    // --------------------------------------------------------------------------------
    //
    // --------------------------------------------------------------------------------

}
