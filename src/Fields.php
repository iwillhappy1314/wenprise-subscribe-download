<?php

namespace SubscribeDownload;


use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Fields
{

    public function __construct()
    {
        add_action('carbon_fields_register_fields', [$this, 'register_fields']);
        add_action('after_setup_theme', [$this, 'load_fields']);

    }


    function register_fields()
    {
        Container::make('theme_options', 'subscribe_to_download_options', __('Subscribe to Download Options'))
                 ->set_page_parent('options-general.php')
                 ->add_fields([
                     Field::make('text', 'mailchimp_api_key', __('MailChimp API Key'))->set_required(),
                     Field::make('text', 'mailchimp_list_id', __('MailChimp List ID'))->set_required(),
                 ]);

        Container::make('post_meta', '附加信息')
                 ->where('post_type', 'solution')
                 ->add_fields([
                     Field::make('file', 'attachment', '附件'),
                 ]);
    }


    function load_fields()
    {
        Carbon_Fields::boot();
    }
}