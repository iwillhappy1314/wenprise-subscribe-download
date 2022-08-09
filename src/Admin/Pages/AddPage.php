<?php
/**
 * 导入数据
 *
 * @package WenPrise
 */

namespace SubscribeDownload\Admin\Pages;

class AddPage
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_page']);
    }


    public function add_page()
    {
        add_submenu_page(
            'options-general.php',
            __('Option Page', 'wenprise-subscribe-download'),
            __('Option', 'wenprise-subscribe-download'),
            'manage_options',
            'wenprise-subscribe-download',
            [$this, 'render_page']
        );
    }


    function render_page()
    {
        ?>

        <div class="wrap">
            <h2><?php _e('Import Box Serial Number', 'wenprise-subscribe-download'); ?></h2>
        </div>

        <?php

    }

}



