<?php
/**
 * 2017年11月21日15:02:28
 * Angela 
 * 功能： 定义项目全局配置
 */

defined("__CONFIG__")   or  define("__CONFIG__",APP_PATH."/config/");           // 配置路径
defined("__STROAGE__")  or  define("__STROAGE__",APP_PATH."/storage/");         // 业务存储路径
defined("__LOG__")      or  define("__LOG__",APP_PATH."/storage/log/");         // 业务存储路径
defined("__VIEW__")     or  define("__VIEW__",APP_PATH."/app/View/");         // 视图存储路径  video 视频模板  game  游戏模板
defined("__UPLOAD__")   or  define("__UPLOAD__",APP_PATH."/public/resources/");         // 业务存储路径
defined("__CKFINDER__") or  define("__CKFINDER__",APP_PATH.'/public/ckfinder/');         // 业务存储路径
                  


// celcom订阅配置信息 获取aocToken接口文档
defined("CELCOM")               or  define("CELCOM",'http://120.76.101.146:22180');  
defined("CELCOM_AOCTOKEN_API")  or  define("CELCOM_AOCTOKEN_API",CELCOM.'/subscribe/malaysia/celcom/receive/'); //获取ID 直接到AOC
defined("CELCOM_UNSUB_API")  or  define("CELCOM_UNSUB_API",CELCOM.'/subscribe/malaysia/celcom/unsub/'); //退订接口

// 定义
return [
    'callback'  =>  'username',     // 缓存数据键
    'device'    =>  'deviceNo',     // 设备号
    'userlogin' =>  'userlogin',     //用户登录
    'para'      =>  'parameter',          // 参数信息
    'expire'    =>  604800,
    'sptransid' =>  'sptransid',         // 退订时使用
    
    // 网站配置信息
    'title'         =>  'MG Play Mobile',  // MG玩移动版下载应用
    'keywords'      =>  'Android games, Android, Android, Android, Android, Android, and Android', // 安卓游戏下载、安卓大型游戏、安卓Android、安卓游戏免费下载、安卓大全
    'description'   =>  'MG plays the android mobile gaming platform, which provides android with packet of large games, android single-player games and android game downloads', //MG玩安卓手机游戏平台，提供安卓带数据包的大型游戏、安卓单机游戏和安卓网络游戏下载
    
    
];