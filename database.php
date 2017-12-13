<?php
/**
 * 2017年11月21日14:53:14
 * Angela  
 * 功能：配置数据链接池
 */
return [
    // 默认链接
    'default'=>[
        'driver'    => 'mysql',
        'host'      => '192.168.4.238',
        'database'  => 'celcom',
        'username'  => 'celcom',
        'password'  => 't6TVATlbRqoT7bds',
        'port'      => '21406',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ],
    'subscribe'=>[
        'driver'    => 'mysql',
        'host'      => '120.76.101.146',
        'database'  => 'subscribe_malaysia',
        'username'  => 'subscribe_malaysia',
        'password'  => 'ta5SOPkJcyI248YT3aSDYP7CynbPFkkC',
        'port'      => '3306',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]
   
    

];
