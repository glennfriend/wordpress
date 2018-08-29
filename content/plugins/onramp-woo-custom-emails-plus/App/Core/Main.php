<?php

namespace Onramp_Woo_Custom_Emails_Plus\App\Core;

use OnrampMini\Core\MainBase;
use Onramp_Woo_Custom_Emails_Plus\App\Template;

/**
 * Class Main
 */
class Main extends MainBase
{

    public function __construct()
    {
        $adminInfo = <<<"EOD"
<pre>    add new template to "<b>Woo Custom Emails</b>" plugin:
        {onramp_woo_custom_emails_plus_version}
        {onramp_woo_custom_emails_plus_order_itmes}
        {onramp_woo_custom_emails_plus_order_items_and_count}
        {onramp_woo_custom_emails_plus_order_total}
</pre>
EOD;
        $this->set('admin_info', $adminInfo);
        $this->set('priority', 1000);
    }

    public function start()
    {
        add_filter('wcemails_find_placeholders', [$this, 'wooCustomEmailsTemplatesPlus'], $this->get('priority'), 2);
    }

    /**
     * 幫助 "Woo Custom Emails" plugin 加上更多的 template variables
     *
     * @param $placeholders
     * @param $object
     * @return mixed
     */
    public function wooCustomEmailsTemplatesPlus($placeholders, $object)
    {
        if (! isset($placeholders['{site_title}'])) {
            return $placeholders;
        }

        $placeholders['{onramp_woo_custom_emails_plus_version}'] = '1.0';

        $template = new Template\OrderItems($object);
        $placeholders['{onramp_woo_custom_emails_plus_order_itmes}'] = $template->render();

        $template = new Template\OrderItemsAndCount($object);
        $placeholders['{onramp_woo_custom_emails_plus_order_items_and_count}'] = $template->render();

        $template = new Template\OrderTotal($object);
        $placeholders['{onramp_woo_custom_emails_plus_order_total}'] = $template->render();


        return $placeholders;
    }

}
