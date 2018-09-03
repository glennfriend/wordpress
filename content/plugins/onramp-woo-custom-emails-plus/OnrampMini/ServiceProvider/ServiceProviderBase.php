<?php

namespace OnrampWooCustomEmailsPlus\OnrampMini\ServiceProvider;

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
    public function __construct(string $file)
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

    public function execute($class)
    {
        (new $class($this))->perform($this);
    }
}
