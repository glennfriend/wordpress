
<h2 class="nav-tab-wrapper sengrid-settings-nav-bar">
    <a href="?page=onrampwoocustomemailsplus_settings&tab=aaa" class="nav-tab nav-tab-active"> hello 1 </a>
    <a href="?page=onrampwoocustomemailsplus_settings&tab=bbb" class="nav-tab "> hello 2 </a>
    <a href="?page=onrampwoocustomemailsplus_settings&tab=ccc" class="nav-tab "> hello 3 </a>
</h2>

<?php

$title = esc_html(get_admin_page_title());
$sgnonce = wp_create_nonce('sgnonce');

echo '<div class="wrap">';
echo "    <h1>{$title}</h1>";
// echo '    <form action="options.php" method="post">';
// options-general.php?page=sendgrid-settings&tab=general
//echo '    <form action="options-general.php?page=onrampwoocustomemailsplus_settings&tab=general" method="post">';
echo '    <form action="" method="post">';
echo '<input type="hidden" name="sgnonce" value="' . $sgnonce .'"/>';

echo '
    <select id="free1" data-custom="custom" name="onrampwoocustomemailsplus_settings_free1">
        <option value="red" >Red Option</option>
        <option value="green" >Green Option</option>
        <option value="yellow" >Yellow Option</option>
    </select>
';




// register_setting($this->pageId, 'onrampwoocustomemailsplus_settings_free1');

settings_fields($this->pageId); // wp_nonce_field($this->pageId);
do_settings_sections($this->pageId);
submit_button('Save Settings');

echo '      目前還無法儲存 !';


echo '    </form>';
echo '</div>';




/*
echo '<pre>';
    print_r($this);
    print_r($views);
    echo $status;
echo '</pre>';
*/


function free_1_options($args)
{
    $options = get_option($this->optionName);

    // echo '<pre style="margin-left:200px;">';
    // print_R($options);
    // echo '</pre>';

    $labelFor = $args['label_for'];
    $id = esc_attr($labelFor);
    $data = $args['data_custom'];
    $name = "{$this->optionName}[{$id}]";
    $items = [
        'red'    => 'Red Option',
        'green'  => 'Green Option',
        'yellow' => 'Yellow Option',
    ];

    echo  <<<"EOD"
            <select id="{$id}" data-custom="{$data}" name="{$name}">
EOD;

    foreach ($items as $value => $show) {
        $focus = null;
        if (isset($options[$labelFor])) {
            $focus = selected($options[$labelFor], $value, false);
        }

        echo '<option value="'. $value .'" '. $focus.'>';
        echo    esc_html_e($show, $this->pageId);
        echo '</option>';
        echo "\n";
    }

    echo  <<<"EOD"
            </select>
            <p class="description">Free1 Description</p>
EOD;

}
