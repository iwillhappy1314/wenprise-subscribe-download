<?php

namespace SubscribeDownload\Views\Shortcodes;

class QueryShortcode
{
    public function __construct()
    {
        add_shortcode('wenprise_subscribe_download_serial_validator', [$this, 'render']);
    }


    public function render()
    {
        $template = WENPRISE_SUBSCRIBE_DOWNLOAD_PATH . 'resources/templates/validator.php';

        include $template;
    }
}