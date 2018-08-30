<?php

namespace OnrampWooCustomEmailsPlus;

use OnrampWooCustomEmailsPlus\App\ServiceProvider;

/**
 * Plugin Name: Onramp_Woo_Custom_Emails_Plus
 * Plugin URI:
 * Description: Add some email template variables. Dependency by "Woo Custom Emails" v2.2
 * Version: 1.0
 * Author: Onramp
 * Author URI:
 * Requires at least:
 * Tested up to:
 * Text Domain:
 *
 * @package Onramp_Woo_Custom_Emails_Plus
 * @category Core
 * @author Onramp
 */
defined('ABSPATH') || exit;




if (! class_exists(ServiceProvider::class)) {

    // register_activation_hook( __FILE__, 'your_activation_function')
    //
    // register_deactivation_hook( __FILE__, 'your_deactivation_function')
    //      remove temp files/folders, flush permalinks
    // register_uninstall_hook( __FILE__, 'your_uninstall_function')
    //      remove database & options
    //
    // 遵守自 => https://developer.wordpress.org/plugins/the-basics/uninstall-methods/

    $onramp_woo_custom_emails_plus_init = function()
    {
        include_once('autoloader.php');
        $instance = new ServiceProvider(__FILE__);
        $instance->start();
    };
    $onramp_woo_custom_emails_plus_init();

}


