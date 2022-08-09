<?php

use SubscribeDownloadVendor\Wenprise\Dispatcher\Router;

$routers = [
    'wenprise-subscribe-download' => ['\SubscribeDownload\Controllers\SerialsController', 'index'],
];

// 社交响应
Router::routes(apply_filters('wenprise_subscribe_download_routers', $routers));