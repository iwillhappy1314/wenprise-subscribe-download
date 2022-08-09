<?php

namespace SubscribeDownload;


class Frontend
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        // add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
    }


    public function enqueue_scripts()
    {

        $enqueue = new \WPackio\Enqueue( 'wenpriseSubscribeDownload', 'dist', '1.0.0', 'plugin', WENPRISE_SUBSCRIBE_DOWNLOAD_MAIN_FILE );
        $assets = $enqueue->enqueue( 'frontend', 'main', [] );

        $entry_point = array_pop( $assets['js'] )['handle'];

        wp_localize_script($entry_point, 'subscribeDownloadApiSettings', [
            'root'  => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest'),
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }


    public function admin_enqueue_scripts()
    {
        global $pagenow;

        $enqueue = new \WPackio\Enqueue( 'wenprise-subscribe-download', 'dist', '1.0.0', 'plugin', WENPRISE_SUBSCRIBE_DOWNLOAD_MAIN_FILE );
        $assets = $enqueue->enqueue( 'admin', 'main', [] );

        $entry_point = array_pop( $assets['js'] )['handle'];

        wp_localize_script($entry_point, 'subscribeDownloadSettings', [
            'root'  => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest'),
        ]);

        // 判断是否为可变商品
        if ($pagenow === 'post.php' && get_post_type($_GET[ 'post' ]) === 'product') {
            wp_enqueue_style('wenprise-subscribe-download-admin', Helpers::get_assets_url('admin', 'admin.css'), [], WENPRISE_SUBSCRIBE_DOWNLOAD_VERSION, 'screen');
            wp_enqueue_script('wenprise-subscribe-download-admin', Helpers::get_assets_url('admin', 'scripts.js'), ['wenprise-subscribe-download-runtime'], WENPRISE_SUBSCRIBE_DOWNLOAD_VERSION, true);
        }
    }
}
