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



    // ================================================================================
    //  wordpress (位置可能不同)
    // ================================================================================
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


    // ================================================================================
    //  load plugin composer autoload.php
    // ================================================================================
    // 暫時略過
    // 不確定多個 composer autoload 能不能併存
    // 就算能併存也可能會有 衝突 的可能


    // ================================================================================
    //  wordpress composer
    // ================================================================================
    // 主程式會載入, 不必多做


    // ================================================================================
    //  plugin autoloader
    // ================================================================================
    echo "load plugin namespace autoloader.php => ";
    $pluginAutoloader = realpath(__DIR__ . '/../Autoloader.php');
    if ($pluginAutoloader) {
        require_once $pluginAutoloader;
        echo "Success\n";
    }
    else {
        echo "Error:\n";
        exit;
    }


    // ================================================================================
    //  build plugin main php
    // ================================================================================
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
        include_once('Autoloader.php');
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

