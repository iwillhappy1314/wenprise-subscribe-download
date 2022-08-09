<?php

namespace SubscribeDownload\Admin\Pages;


class AdminIndexPage
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    /**
     * Register our menu page
     *
     * @return void
     */
    public function admin_menu()
    {
        global $submenu;

        $capability = 'manage_options';
        $slug       = 'wenprise-subscribe-download-admin';

        $hook = add_menu_page(__('Packages', 'wenprise-subscribe-download'), __('Packages', 'wenprise-subscribe-download'), $capability, $slug, [$this, 'render'], 'dashicons-text');

        if (current_user_can($capability)) {
            $submenu[ $slug ][] = [__('App', 'wenprise-subscribe-download'), $capability, 'admin.php?page=' . $slug . '#/'];
            $submenu[ $slug ][] = [__('Settings', 'wenprise-subscribe-download'), $capability, 'admin.php?page=' . $slug . '#/settings'];
        }

        add_action('load-' . $hook, [$this, 'init_hooks']);
    }

    /**
     * Initialize our hooks for the admin page
     *
     * @return void
     */
    public function init_hooks()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style('wenprise-subscribe-download-admin', \SubscribeDownload\Helpers::get_assets_url('admin', 'vendors~admin.css'), [], WENPRISE_SUBSCRIBE_DOWNLOAD_VERSION, 'screen');

        wp_enqueue_script('wenprise-subscribe-download-admin-runtime', \SubscribeDownload\Helpers::get_assets_url('admin', 'runtime.js'), [], WENPRISE_SUBSCRIBE_DOWNLOAD_VERSION, true);

        wp_enqueue_script('wenprise-subscribe-download-vendors-admin', \SubscribeDownload\Helpers::get_assets_url('admin', 'vendors~admin.js'), [], WENPRISE_SUBSCRIBE_DOWNLOAD_VERSION, true);

        wp_enqueue_script('wenprise-subscribe-download-admin', \SubscribeDownload\Helpers::get_assets_url('admin', 'admin.js'), ['wenprise-subscribe-download-admin-runtime', 'wenprise-subscribe-download-vendors-admin'], WENPRISE_SUBSCRIBE_DOWNLOAD_VERSION, true);

        wp_localize_script('wenprise-subscribe-download-admin', 'wpTransshipSettings', [
            'root'  => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest'),
        ]);
    }

    /**
     * Render our admin page
     *
     * @return void
     */
    public function render()
    {
        echo '<div class="wrap"><div id="wenprise-subscribe-download-admin"></div></div>';
    }
}