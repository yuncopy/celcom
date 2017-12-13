<?php

/* * *******************************************************************************
 * InitPHP 3.8.2 国产PHP开发框架   - 工具库-cookie
 * -------------------------------------------------------------------------------
 * 版权所有: CopyRight By initphp.com
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * -------------------------------------------------------------------------------
 * Author:zhuli Dtime:2014-11-25
 * ********************************************************************************* */

class Cookie{

    static $prefix = "Angela_"; //cookie前缀
    static $expire = 2592000; //cookie时间
    static $path = '/'; //cookie路径
    static $domain = '';

    /**
     * 设置cookie的值
     * 使用方法：self::$getUtil('cookie')->set();
     * @param  string $name    cookie的名称
     * @param  string $val     cookie值
     * @param  string $expire  cookie失效时间
     * @param  string $path    cookie路径
     * @param  string $domain  cookie作用的主机
     * @return string   
     */
    static public function set($name, $val, $expire = '', $path = '', $domain = '') {
        $expire = (empty($expire)) ? time() + self::$expire : $expire; //cookie时间
        $path = (empty($path)) ? self::$path : $path; //cookie路径
        $domain = (empty($domain)) ? self::$domain : $domain; //主机名称
        if (empty($domain)) {
            setcookie(self::$prefix . $name, $val, $expire, $path);
        } else {
            setcookie(self::$prefix . $name, $val, $expire, $path, $domain);
        }
        $_COOKIE[self::$prefix . $name] = $val;
    }

    /**
     * 获取cookie的值
     * 使用方法：self::$getUtil('cookie')->get($name);
     * @param  string $name    cookie的名称
     * @return string   
     */
    static public function get($name) {
        return isset($_COOKIE[self::$prefix . $name]) ? $_COOKIE[self::$prefix . $name] : '';
    }

    /**
     * 删除cookie值
     * 使用方法：self::$getUtil('cookie')->del($name)
     * @param  string $name    cookie的名称
     * @param  string $path    cookie路径
     * @return string   
     */
    static public function del($name, $path = '') {
        self::set($name, '', time() - 3600, $path);
        $_COOKIE[self::$prefix . $name] = '';
        unset($_COOKIE[self::$prefix . $name]);
    }

    /**
     * 检查cookie是否存在
     * 使用方法：self::$getUtil('cookie')->is_set($name)
     * @param  string $name    cookie的名称
     * @return string   
     */
    static public function is_set($name) {
        return isset($_COOKIE[self::$prefix . $name]);
    }

}
