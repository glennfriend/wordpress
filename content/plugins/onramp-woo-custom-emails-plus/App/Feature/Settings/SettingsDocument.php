<?php

namespace OnrampWooCustomEmailsPlus\App\Feature\Settings;

class SettingsDocument
{

    const TAB = 'document';
    const LABEL = 'Document';
    const SHOW_SUBMIT = false;

    /**
     * @param $pageId
     * @param $saveName
     */
    public function __construct($pageId, $saveName)
    {
        $this->pageId = $pageId;
        $this->saveName = $saveName;
    }

    /**
     *
     */
    public function page()
    {
        $title = null;
        register_setting($this->pageId, $this->saveName);
        add_settings_section($this->pageId, $title, [$this, 'top_section'], $this->saveName);
    }

    /**
     *
     */
    public function top_section()
    {
        echo <<<"EOD"
<div style="padding: 10px 15px 10px 15px;">
    <span lang="en">Copyright (C) &lt;year&gt; &lt;copyright holders&gt;<br />
        <p>
            <br />
            Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:<br />
            <br />
            The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.<br />
            <br />
            THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
        </p>
    </span>
</div>
EOD;
    }

    // ================================================================================
    //  input fields
    // ================================================================================

}
