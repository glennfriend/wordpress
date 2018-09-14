<?php

namespace MySecurity\App\Feature\DependencyCheck;

use MySecurity\OnrampMini\Core\Controller;
use MySecurity\OnrampMini\Lib\WordpressDispaly;

class DependencyCheck extends Controller
{
    /**
     * @return bool
     */
    public function perform()
    {
        $this->display = new WordpressDispaly();

        //
        if (! $this->phpVersionCheck()) {
            return false;
        }

        return true;
    }

    /**
     * php version check
     */
    public function phpVersionCheck()
    {
        $phpVersionDefine = '5.6.0';
        if (version_compare(phpversion(), $phpVersionDefine, '<')) {
            $this->display->error("Plugin requires PHP >= {$phpVersionDefine}");
            $this->display->showAll();
            return false;
        }

        return true;
    }

}
