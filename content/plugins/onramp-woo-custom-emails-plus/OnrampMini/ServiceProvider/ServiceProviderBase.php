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
    public $file;

    /**
     * @var int
     */
    public $priority = 1000;

    /**
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function execute($class)
    {
        (new $class($this))->perform($this);
    }
}
