<?php

/**
 * 2017年11月22日19:39:18
 * Angela
 * 功能：redis 操作类
 */

use Predis\Client;
class Redis{

    private $redis = null;
    private $mode = null;
    private $server = array(
        'scheme'=>'tcp',
        'host' => '127.0.0.1',
        'port' => 6379,
        'auth' =>'',
        'database' => 7
    );
    
    // 实例化
    public function __construct() {
        
        if (!extension_loaded("redis")) {
            if (is_null($this->redis)) {
                $server= $this->server;
                $redis = new Client($server);
                $this->redis = $redis;
            }
        }else{
            if (is_null($this->redis)) {
                $this->connect();
                $this->mode = true ;
            }
        }
    }
    
    // 链接数据库
    public function connect() {
        $redis = new Redis();
        $conf = $this->server;
        try {
            $ret = $redis->connect($conf["host"], $conf["port"]);
            $redis->auth($conf["auth"]);
            $redis->select($conf["database"]);
            if ($ret) {
                $this->redis = $redis;
            } else {
                die("<br/>redis connect failed!");
            }
        } catch (Exception $e) {
            die("<br/>redis connect error:" . $e->getMessage());
        }
    }
    
    // __call是调用未定义的方法时调用的
    public function __call($method, $arguments) {
        $funcArr = array($this->redis, $method);
        if($this->mode){
            if (!method_exists($this->redis, $method)) {
                die("<br/>Error::method:" . $method . "  is not exist!");
            }
        }
        return call_user_func_array($funcArr, $arguments);
    }
    
    //获取redis 实例
    public function getRedis() {
        return $this->redis;
    }

}
