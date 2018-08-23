<?php

namespace Onramp_Woo_Custom_Emails_Plus;

use Onramp_Woo_Custom_Emails_Plus\App\ServiceProvider;

/**
 * Plugin Name: Onramp_Woo_Custom_Emails_Plus
 * Plugin URI:
 * Description: Dependency by "Woo Custom Emails", 增加一些 email template 的變數
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


if (! class_exists('Onramp_Woo_Custom_Emails_Plus')) {
    // ServiceProvider::class

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
        include_once('App/Functions/autoloader.php');
        $instance = new ServiceProvider(__DIR__);
        $instance->init();
    };
    $onramp_woo_custom_emails_plus_init();

}



/*
    if ( version_compare( phpversion(), '5.4.0', '<' ) ) {

        add_action( 'admin_notices', 'php_version_error' );

        function php_version_error()
        {
            echo '<div class="error"><p>' . __('SendGrid: Plugin requires PHP >= 5.4.0.') . '</p></div>';
        }

        return;
    }
*/

