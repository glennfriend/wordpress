<?php

namespace Onramp_Woo_Custom_Emails_Plus\App\Template;

class OrderTotal
{

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function render()
    {
        $items = $this->object->get_items();
        $allTotal = 0;

        foreach($items as $item) {
            $total = $item->get_total();
            $allTotal += $total;
        }

        return $allTotal;
    }

}
