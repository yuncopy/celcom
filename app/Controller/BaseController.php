<?php

/**
 * 2017年12月4日11:20:40
 * Angela
 * 后台基础控制器
 */
namespace App\Controller;
use App\Service\LoginService;
use App\Service\AuthService;
class BaseController extends CommonController{
    
   
    /**
     * 构造方式
     */
    public function __construct() {
        parent::__construct();
        $userCookie = LoginService::getUserCookie();
        if(!$userCookie){  //登录校验
            return  redirect('/login/login.html');
        }
        $can = AuthService::checkUserRule(); 
        if(!$can){ //权限校验
           return  redirect('/login/error.html');
        }
    }
}
