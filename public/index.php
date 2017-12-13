<?php
define("APP_PATH",  realpath(dirname(__FILE__) . '/../')); /* 指向public的上一级 */
require APP_PATH.'/vendor/autoload.php'; // Autoload 自动载入
require APP_PATH.'/app/bootstrap.php'; // 启动器
require APP_PATH.'/config/routes.php'; // 路由配置、开始处理

