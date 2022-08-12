<?php

namespace SubscribeDownload;

use DrewM\MailChimp\MailChimp;


class Init
{

    /**
     * constructor.
     */
    public function __construct()
    {
        $classes = [
            Frontend::class,
            Fields::class,
        ];

        foreach ($classes as $class) {
            new $class;
        }

        add_action('wp_ajax_wsd_subscribe', [$this, 'wsd_subscribe']);
        add_action('wp_ajax_nopriv_wsd_subscribe', [$this, 'wsd_subscribe']);

        add_action('wp_footer', [$this, 'load_modal_template']);
    }


    /**
     * 订阅邮件列表
     *
     * @return void
     * @throws \Exception
     */
    function wsd_subscribe()
    {

        $MailChimp = new MailChimp(get_option('_mailchimp_api_key'));
        $file_id   = $_POST[ 'post_id' ] ?? null;

        if (isset($_POST[ 'email' ])) {
            $list_id = get_option('_mailchimp_list_id');

            $result = $MailChimp->post("lists/$list_id/members", [
                'email_address' => $_POST[ 'email' ],
                'status'        => 'subscribed',
            ]);

            if ($result) {
                wp_send_json_success([
                    'result' => 'success',
                    'url'    => wp_get_attachment_url($file_id),
                    'name'   => basename(get_attached_file($file_id)),
                ]);
            }
        }

    }


    /**
     * 加载Modal模版
     *
     * @return void
     */
    function load_modal_template()
    {
        $helper = new \WenpriseTemplateHelper('wenprise', WENPRISE_SUBSCRIBE_DOWNLOAD_PATH . 'templates/');
        $helper->get_template('wsd-modal.php', '');
    }

}