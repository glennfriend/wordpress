<?php

namespace Onramp_Woo_Custom_Emails_Plus\App;

/**
 * Class WordpressDispaly
 */
final class WordpressDispaly
{
    protected $messages;

    public function __construct()
    {
        $this->reset();
    }

    public function success($message)
    {
        $this->messages['success'][] = $message;
    }

    public function error($message)
    {
        $this->messages['error'][] = $message;
    }

    public function info($message)
    {
        $this->messages['info'][] = $message;
    }

    public function warning($message)
    {
        $this->messages['warning'][] = $message;
    }

    public function showAll()
    {
        if ($message = $this->messages['success']) {
            array_unshift($message, $this->getNamespaceShow());
            echo '<div class="notice notice-success"><p>' . join("<br>\n", $message) .'</p></div>';
        }

        if ($message = $this->messages['error']) {
            array_unshift($message, $this->getNamespaceShow());
            echo '<div class="notice notice-error"><p>' . join("<br>\n", $message) .'</p></div>';
        }

        if ($message = $this->messages['info']) {
            array_unshift($message, $this->getNamespaceShow());
            echo '<div class="notice notice-info"><p>' . join("<br>\n", $message) .'</p></div>';
        }

        if ($message = $this->messages['warning']) {
            array_unshift($message, $this->getNamespaceShow());
            echo '<div class="notice notice-warning"><p>' . join("<br>\n", $message) .'</p></div>';
        }

        $this->reset();
    }

    // ================================================================================
    //  private
    // ================================================================================

    protected function getNamespaceShow()
    {
        return '[' . $this->getNamespace() . ']';
    }

    protected function getNamespace()
    {
        return explode("\\", __NAMESPACE__)[0];
    }

    protected function reset()
    {
        $this->messages = [
            'success' => [],
            'error' => [],
            'info' => [],
            'warning' => [],
        ];
    }
}
