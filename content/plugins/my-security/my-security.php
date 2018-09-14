<?php
//
// This file is automatically generated
// Please do not modify this file
//

namespace MySecurity;
use MySecurity\App\ServiceProvider;

/**
 * Plugin Name: My Security
 * Plugin URI: 
 * Description: Modify wordpress security
 * Version: 1.0.0
 * Author: Onramp
 * Author URI: 
 */
defined('ABSPATH') || exit;

if (! class_exists(ServiceProvider::class)) {
    $init = function() {
        include_once('Autoloader.php');
        $instance = new ServiceProvider(__FILE__);
        $instance->start();
    };
    $init();
}

