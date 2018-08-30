<?php

namespace OnrampWooCustomEmailsPlus\App\Feature\EmailTemplatePlus\Template;

/**
 * example
 *      "book1 x 5, book2 x 30"
 */
class OrderItemsAndCount
{

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function render()
    {
        $items = $this->object->get_items();
        $messages = [];

        foreach($items as $item) {
            $name = $item->get_name();
            $quantity = $item->get_quantity();
            $messages[] = "{$name} x {$quantity}";
        }

        return join(", ", $messages);
    }

}
