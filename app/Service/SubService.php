<?php
/**
 * 2017年11月24日12:03:25
 * Angela 
 * 功能:AOC界面处理
 * 
 */
namespace App\Service;
class SubService extends CommonService{

   /**
    * 2017年11月28日18:41:36
    * Angela
    * 用户订阅成功
    */
    public static function subSuccess($msisdn,$pwd,$login=false){
        // 设置Cookie 让用户进行免登录
        $callback = Config('app.callback');
        if($login){
            $expire = time() + 3600 * 24 * 365 * 10;  // 365*24 小时  10 年
        }else{
            $expire = -1;  // 关闭浏览器时生效
        }
        // 设置缓存，进行免登录操作
        $username = encode("{$msisdn}|{$pwd}");  // 加密保存
        \Cookie::set($callback, $username, $expire);
        return true;
    }
    
    
    /**
    * 2017年11月28日18:41:36
    * Angela
    * 用户订阅成功
    */
    public static function subLogout(){
        // 设置Cookie 让用户进行免登录
        $callback = Config('app.callback');
        \Cookie::del($callback);
        return true;
    }
    
    /**
    * 2017年11月28日18:41:36
    * Angela
    * 检查订阅成功
    */
    public static function  checkSub(){
        
        $callback = Config('app.callback');
        $callback_value = \Cookie::get($callback);
        $vip = false;
        if($callback_value){
            $vip = true;
        }
        return $vip;
    }
    
    
     /**
    * 2017年11月28日18:41:36
    * Angela
    * 检查订阅成功
    */
    public static function  getSubMsisdn(){
        $callback = Config('app.callback');
        $data = \Cookie::get($callback);
        $name = $pass = '';
        if($data){
            $data_decode = decode($data);
            $data_call = explode('|', $data_decode);
            $name = $data_call[0];
            $pass = $data_call[1];
        }
        return ['name'=>$name,'info'=>$pass];
    }
    
    
    /**
     * 2017年12月12日16:57:55
     * Angela
     * 订阅参数
     */
    public static function getAndSetSubPara($data=null){
        $para = Config('app.para');
        if($data && is_array($data)){
            $subData = json_encode($data);  // 加密保存
            $expire = time() + Config('app.expire');
            \Cookie::set($para, $subData, $expire);
            $resData = $data;
        }else{
            $resJson= \Cookie::get($para);
            $resData = json_decode($resJson, true);
        }
        return $resData;
    }
    
    
    /**
     *2017年12月13日12:12:34
     * Angela 
     * 获取退订spTransID
     */
    
    public static function spTransIDSetAndGet($data=null){
        $sptransid_key = Config('app.sptransid');
        if($data){
            $expire = time() + Config('app.expire');
            \Cookie::set($sptransid_key, $data, $expire);
            $resData = $data;
        }else{
            $resData = \Cookie::get($sptransid_key);
        }
        return $resData;
    }
    
    
    
}