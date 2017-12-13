<?php
namespace App;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

//Eloquent ORM
{
    $capsule = new Capsule;
    $config = require APP_PATH.'/config/database.php';  // 获取数据库信息

    foreach ($config as $key => $value){
        $capsule->addConnection($value,$key); // 创建链接
    }
    $capsule->setEventDispatcher(new Dispatcher(new Container));
    $capsule->setAsGlobal(); // 设置全局静态可访问
    $capsule->bootEloquent(); // 启动Eloquent
}
// whoops 错误提示
{
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}
//定义系统配置文件
{
    require APP_PATH.'/config/app.php';
}

