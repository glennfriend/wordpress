<?php

namespace MySecurity\OnrampMini\ServiceProvider;

use Exception;

/**
 * Class ServiceProvider
 */
class ServiceProviderBase
{
    /**
     * @var string
     */
    public $version = '1.0.0';

    /**
     * @var int
     */
    public $priority = 1000;

    /**
     * @var string
     */
    public $namespace;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $key;

    /**
     * @var string
     */
    public $file;

    /**
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file = $file;
        $this->namespace = explode("\\", __NAMESPACE__)[0];
        $this->key  = strtolower($this->namespace . '_');

        // "Namespace_YourPluginName" conver to "Namespace Your Plugin Name"
        $search = [
            '/[A-Z]/s',
            '/_/s',
            '/ +/s',
        ];
        $replace = [
            ' $0',
            ' ',
            ' ',
        ];
        $this->name = trim(preg_replace($search, $replace, $this->namespace));


        $this->init();
    }

    public function init()
    {
        // please rewrite
    }

    /**
     * 產生 plugin main 程式的時候要使用到的資訊
     */
    public function buildPluginInformation()
    {
        /**
         * Plugin Name:
         * Plugin URI:
         * Description:
         * Version:
         * Author: Onramp
         * Author URI:
         * Requires at least:
         * Tested up to:
         * Text Domain:
         */

        if (! isset($this->build_plugin_info)) {
            $this->build_plugin_info = [];
        }
        if (! is_array($this->build_plugin_info)) {
            $this->build_plugin_info = [];
        }

        // PHP5
        $this->build_plugin_info['plugin_name'] = isset($this->build_plugin_info['plugin_name'])    ? $this->build_plugin_info['plugin_name']   : $this->name;
        $this->build_plugin_info['plugin_uri']  = isset($this->build_plugin_info['plugin_uri'])     ? $this->build_plugin_info['plugin_uri']    : null;
        $this->build_plugin_info['description'] = isset($this->build_plugin_info['description'])    ? $this->build_plugin_info['description']   : null;
        $this->build_plugin_info['author']      = isset($this->build_plugin_info['author'])         ? $this->build_plugin_info['author']        : null;
        $this->build_plugin_info['author_uri']  = isset($this->build_plugin_info['author_uri'])     ? $this->build_plugin_info['author_uri']    : null;

        /*
        // PHP7
        $this->build_plugin_info['plugin_name'] = $this->build_plugin_info['plugin_name']   ?? $this->name;
        $this->build_plugin_info['plugin_uri']  = $this->build_plugin_info['plugin_uri']    ?? null;
        $this->build_plugin_info['description'] = $this->build_plugin_info['description']   ?? null;
        $this->build_plugin_info['author']      = $this->build_plugin_info['author']        ?? null;
        $this->build_plugin_info['author_uri']  = $this->build_plugin_info['author_uri']    ?? null;
        */
    }

    public function execute($class)
    {
        return (new $class($this))->perform();
    }

}
