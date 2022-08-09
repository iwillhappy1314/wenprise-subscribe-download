<?php
/*
Plugin Name: Wenprise subscribe to download
Plugin URI: https://www.wpzhiku.com/
Description: Description
Version:            1.0.0
Author: 一刀
Author URI: https://www.wpzhiku.com
*/

defined('WPINC') || die;

const WENPRISE_SUBSCRIBE_DOWNLOAD_VERSION   = '1.0.0';
const WENPRISE_SUBSCRIBE_DOWNLOAD_MAIN_FILE = __FILE__;
define('WENPRISE_SUBSCRIBE_DOWNLOAD_PATH', plugin_dir_path(__FILE__));
define('WENPRISE_SUBSCRIBE_DOWNLOAD_URL', plugin_dir_url(__FILE__));

if ( ! is_file(WENPRISE_SUBSCRIBE_DOWNLOAD_PATH . 'vendor/autoload.php')) {
    spl_autoload_register(function ($class)
    {
        $prefix = 'SubscribeDownload';

        if (strpos($class, $prefix) === false) {
            return;
        }

        $class    = substr($class, strlen($prefix));
        $location = WENPRISE_SUBSCRIBE_DOWNLOAD_PATH . 'src' . str_replace('\\', '/', $class) . '.php';

        if (is_file($location)) {
            require_once($location);
        }
    });
} else {
    require_once(WENPRISE_SUBSCRIBE_DOWNLOAD_PATH . 'vendor/autoload.php');
}


register_activation_hook(WENPRISE_SUBSCRIBE_DOWNLOAD_MAIN_FILE, 'wsd_activation');
register_deactivation_hook(WENPRISE_SUBSCRIBE_DOWNLOAD_MAIN_FILE, 'wsd_deactivation');
register_uninstall_hook(WENPRISE_SUBSCRIBE_DOWNLOAD_MAIN_FILE, 'wsd_uninstallation_action_action');

function wsd_activation()
{
    new SubscribeDownload\Actions\ActivationAction();
}


function wsd_deactivation()
{
    new SubscribeDownload\Actions\DeactivationAction();
}


function wsd_uninstallation_action_action()
{
    new SubscribeDownload\Actions\DeactivationAction();
}


add_action('plugins_loaded', function ()
{
    load_plugin_textdomain('wenprise-subscribe-download', false, dirname(plugin_basename(__FILE__)) . '/languages/');

    new \SubscribeDownload\Init();
});


/**
 * 显示下载按钮
 *
 * @param $attachment_id
 *
 * @return void
 */
function wsd_the_download_button($attachment_id): void
{
    ?>

    <a class='border border-solid border-red-700 rounded text-sm px-3 py-2 hover:bg-gray-100 wsd-modal-trigger'
       href='#wsd-download'
       data-wsd-open='wsd-subscribe-modal'
       data-post_id=<?= $attachment_id; ?>
    >
        <span class="icon-download1 mr-2"></span> Download
    </a>

<?php }
