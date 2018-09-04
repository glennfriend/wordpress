<?php

$title = esc_html(get_admin_page_title());

echo '<div class="wrap">';
echo "    <h1>{$title}</h1>";
echo '    <form action="options.php" method="post">';

settings_fields($this->pageId);
do_settings_sections($this->pageId);
submit_button('Save Settings');

echo '    </form>';
echo '</div>';


echo '<pre>';
print_r($this);
print_r($views);
echo $status;
echo '</pre>';
