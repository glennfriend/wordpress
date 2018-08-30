<?php

namespace OnrampWooCustomEmailsPlus\App\Feature\EmailTemplatePlus\Template;

/**
 * example
 *      "book1, book2"
 */
class OrderItems
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
            $messages[] = $name;
        }

        return join(", ", $messages);
    }

}
