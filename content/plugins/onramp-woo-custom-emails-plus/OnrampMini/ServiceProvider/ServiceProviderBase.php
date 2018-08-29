<?php

namespace OnrampMini\ServiceProvider;

/**
 * Class ServiceProvider
 * final ??????
 */
class ServiceProviderBase
{

    protected $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

}
