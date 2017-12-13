<?php
/**
 * 2017年11月24日12:03:25
 * Angela 
 * 功能:AOC界面处理
 * 
 */
namespace App\Service;
class LoginService extends CommonService{

   
    /**、2017年12月4日10:36:04
     * Angela
     * 用户登录使用
     */
    public static function login($data){
        if(is_array($data) && !empty($data)){
            $callback = Config('app.userlogin');
            $expire = time() + Config('app.expire');  // 365*24 小时  10 年  3600 * 24 * 7
            // 设置缓存，进行免登录操作
            $username = encode(json_encode($data));  // 加密保存
            \Cookie::set($callback, $username, $expire);
            return false;
        }
    }
    
    /**
     * 2017年12月4日10:37:04
     * Angela
     * 获取用户信息
     */
    public static function  getUserCookie(){
        $callback = Config('app.userlogin');
        $user = \Cookie::get($callback);
        if($user){
            return json_decode(decode($user),true);
        }
        return false;
    }
    
    
    /**
     * 2017年12月4日10:48:16
     * Angela 
     * 清除Cookie数据
     */
    
    public static function clearUserCookie(){
        $callback = Config('app.userlogin');
        return \Cookie::del($callback);
    }
    
    
    
    
}