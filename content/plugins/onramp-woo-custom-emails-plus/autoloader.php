<?php

namespace OnrampWooCustomEmailsPlus;

spl_autoload_register(__NAMESPACE__ . '\\autoloader');

/**
 * Dynamically loads the class attempting to be instantiated elsewhere in the
 * plugin by looking at the $filename parameter being passed as an argument.
 * Origin Author: https://plugins.svn.wordpress.org/woo-solo-api/tags/1.1/lib/autoloader.php
 *
 * Wordpress 目前暫時無法有效全自動找入 library
 * 當可以自動載入後, 該程式就不再需要
 * 2018-08-23 modify to psr4
 *
 * example
 *      Company_Project_Feature\App\ServiceProvider
 *      =>
 *      /var/www/wordpress/wp-content/plugins/plugin-name/App/ServiceProvider.php
 *
 * @param string $filename The fully-qualified name of the file that contains the class.
 */
function autoloader($filename) {

    $file_path = explode( '\\', $filename );

    $class_file = $file_path[count($file_path) - 1] ?? null;
    if (null !== $class_file) {
        $class_file .= ".php";
    }

    $fully_qualified_path = trailingslashit(__DIR__);

    $file_count = count($file_path);
    for ($i = 1; $i < $file_count - 1; $i++) {
        $dir = $file_path[$i];
        $fully_qualified_path .= trailingslashit($dir);
    }
    $fully_qualified_path .= $class_file;

    // Now we include the file.
    if (file_exists($fully_qualified_path)) {
        require_once($fully_qualified_path);
    }

}
