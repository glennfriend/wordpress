<?php

namespace MySecurity\OnrampMini\Core;

/**
 * Class Base
 */
class MainBase
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param $key
     * @param null $defaultValue
     * @return mixed|null
     */
    public function get($key, $defaultValue=null)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return $defaultValue;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    // --------------------------------------------------------------------------------
    //
    // --------------------------------------------------------------------------------

}
