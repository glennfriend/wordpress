<?php

use OnrampWooCustomEmailsPlus\App\ServiceProvider;

/**
 *
 */
$build = function()
{
    $_SERVER['SERVER_NAME']     = null;
    $_SERVER['SERVER_PORT']     = null;
    $_SERVER['REQUEST_METHOD']  = null;
    $_SERVER['SERVER_PROTOCOL'] = null;


    // composer
    echo "load composer autoload.php           => ";
    $composerAutoload = realpath(__DIR__ . '/../../../../vendor/autoload.php');
    if ($composerAutoload) {
        require_once $composerAutoload;
        echo "Success\n";
    }
    else {
        echo "Fail\n";
    }

    // wordpress (位置可能不同)
    echo "load wordpress wp-blog-header.php    => ";
    $wordpressBlogHeader = realpath(__DIR__ . '/../../../../wordpress/wp-blog-header.php');
    if ($wordpressBlogHeader) {
        require_once $wordpressBlogHeader;
        echo "Success\n";
    }
    else {
        echo "Error\n";
        echo "Tips: you can try\n";
        echo "> locate wp-blog-header.php\n";
        exit;
    }

    // plugin
    echo "load plugin namespace autoloader.php => ";
    $pluginAutoloader = realpath(__DIR__ . '/../autoloader.php');
    if ($pluginAutoloader) {
        require_once $pluginAutoloader;
        echo "Success\n";
    }
    else {
        echo "Error:\n";
        exit;
    }


    // build plugin main php
    $pluginFolder = realpath(__DIR__ . '/..');
    $filename = basename($pluginFolder) . '.php';
    $file = $pluginFolder . '/' . $filename;

    // ================================================================================
    //  check
    // ================================================================================
    echo "\n";
    echo "generate file '" . $filename . "'\n";
    if (file_exists($file)) {
        echo "=> Error\n";
        echo "=> file is exists!\n";
        exit;
    }

    // ================================================================================
    //  get information
    // ================================================================================
    $provider = new ServiceProvider(__FILE__);
    $provider->init();
    $provider->buildPluginInformation();

    extract($provider->build_plugin_info);
    $className = ServiceProvider::class;

    // ================================================================================
    //  template
    // ================================================================================
    $template = <<<"EOD"

//
// This file is automatically generated
// Please do not modify this file
//

namespace {$provider->namespace};
use {$className};

/**
 * Plugin Name: {$plugin_name}
 * Plugin URI: {$plugin_uri}
 * Description: {$description}
 * Version: {$provider->version}
 * Author: {$author}
 * Author URI: {$author_uri}
 */
defined('ABSPATH') || exit;

if (! class_exists(ServiceProvider::class)) {
    \$init = function() {
        include_once('autoloader.php');
        \$instance = new ServiceProvider(__FILE__);
        \$instance->start();
    };
    \$init();
}

EOD;

    // ================================================================================
    //  build
    // ================================================================================
    $template = '<' . '?' . 'php' . "\n" . $template . "\n";
    file_put_contents($file , $template);

    // ================================================================================
    //  check
    // ================================================================================
    if (file_exists($file)) {
        echo "=> Success\n";
    }
    else {
        echo "=> Fail\n";
    }


};

$build();

