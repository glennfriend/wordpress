<?php

//
// This file is automatically generated
// Please do not modify this file
//

namespace OnrampWooCustomEmailsPlus;
use OnrampWooCustomEmailsPlus\App\ServiceProvider;

/**
 * Plugin Name: Onramp Woo Custom Emails Plus
 * Plugin URI: 
 * Description: Add some email template variables. Dependency by "Woo Custom Emails" v2.2
 * Version: 1.0.0
 * Author: Onramp
 * Author URI: 
 */
defined('ABSPATH') || exit;

if (! class_exists(ServiceProvider::class)) {
    $init = function() {
        include_once('autoloader.php');
        $instance = new ServiceProvider(__FILE__);
        $instance->start();
    };
    $init();
}

