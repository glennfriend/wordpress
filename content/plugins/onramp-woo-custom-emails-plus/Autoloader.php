<?php

namespace OnrampWooCustomEmailsPlus;

class Autoloader
{

    public function __construct()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * Wordpress 目前暫時無法有效全自動找入 library
     * 當可以自動載入後, 該程式就不再需要
     * 2018-09-14 modify to psr4
     *
     * example
     *      YourCompany\App\ServiceProvider
     *      =>
     *      /var/www/wordpress/wp-content/plugins/plugin-name/App/ServiceProvider.php
     *
     * @param string $filename The fully-qualified name of the file that contains the class.
     */
    public function loadClass($filename)
    {
        $file_path = explode( '\\', $filename );
        if (! $file_path) {
            return;
        }

        // 只對自己的 namespace 做 autoload
        if (__NAMESPACE__ !== $file_path[0]) {
            return;
        }

        $class_file = $file_path[count($file_path) - 1];
        if (! $class_file) {
            return;
        }

        $class_file .= ".php";

        // $fully_qualified_path = rtrim(__DIR__, '/\\') . '/';
        $fully_qualified_path = trailingslashit(__DIR__);

        $file_count = count($file_path);
        for ($i = 1; $i < $file_count - 1; $i++) {
            $dir = $file_path[$i];
            $fully_qualified_path .= trailingslashit($dir);
            // $fully_qualified_path .= rtrim($dir, '/\\') . '/';
        }
        $fully_qualified_path .= $class_file;

        // Now we include the file.
        if (file_exists($fully_qualified_path)) {
            require_once($fully_qualified_path);
        }
    }

}

new Autoloader();
