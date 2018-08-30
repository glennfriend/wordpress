<?php

namespace OnrampWooCustomEmailsPlus\App\Feature\EmailTemplatePlus;

use OnrampWooCustomEmailsPlus\App\ServiceProvider;
use OnrampWooCustomEmailsPlus\App\Feature\EmailTemplatePlus\Template;

class EmailTemplatePlus
{

    public function perform(ServiceProvider $provider)
    {
        $priority = $provider->priority;

        add_filter('wcemails_find_placeholders', [$this, 'replaceTemplate'], $priority, 2);
    }

    /**
     * 幫助 "Woo Custom Emails" plugin 加上更多的 template variables
     *
     * @param $placeholders
     * @param $object
     * @return mixed
     */
    public function replaceTemplate($placeholders, $object)
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
