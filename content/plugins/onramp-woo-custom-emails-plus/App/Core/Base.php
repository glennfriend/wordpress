<?php

namespace Onramp_Woo_Custom_Emails_Plus\App\Core;

/**
 * Class Base
 */
class Base
{
    /**
     * @var int
     */
    protected $priority = 1000;

    /**
     * @var string
     */
    protected $adminInfo = '';

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return string
     */
    public function getAdminInfo()
    {
        return $this->adminInfo;
    }

}
