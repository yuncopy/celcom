<?php

/**
 * 首页控制
 * 2017年11月21日17:54:32
 */
namespace App\Controller;
use App\Model\UsersModel;
use App\Service\LoginService;
class LoginController extends CommonController{
    
    public function index()
    {
        $this->display('index.html'); 
    }
    
    
    /**
     * 2017年12月1日17:27:32
     * Angela
     * 后台用户登录
     */
    public function login(){
       // echo password_hash('qwer@123',PASSWORD_DEFAULT);
        $username = $this->getPostDatas('POST','username',false,'htmlspecialchars');
        if($username){
           $pass = $this->getPostDatas('POST','pass',false,'htmlspecialchars');
           $rs = (new UsersModel)->checkLogin($username);
           if(password_verify($pass, $rs['pass'])) {
               LoginService::login(['username'=>$username,'pass'=>$pass,'uid'=>$rs['id']]);  // 设置本地
               return  redirect('/file/index.html');  // 后台首页
           }else{
               return  redirect('/login/login.html');
           }
        }else{
            $userCookie = LoginService::getUserCookie();
            if($userCookie){
                return  redirect('/file/index.html');  // 后台首页
            }
            return $this->display('login.html');  // 登录界面
        }
    }
    
    /**
     * 2017年12月1日17:27:32
     * Angela
     * 后台用户登录
     */
    
    public function logout(){
        LoginService::clearUserCookie();  // 清除数据
        return  redirect('/login/login.html'); // 直接跳转
    }




    /**
     * 2017年12月1日17:46:10
     * Angela 
     * 添加用户
     */
    public function insertUser(){
        
        $data=[
            'name'=>'bluepay',
            'pass'=> password_hash('qwer@123',PASSWORD_DEFAULT)
        ];
        $rs = (new UsersModel)->insertOrUpdate($data);

    }
    
    
    
    /**
    * 2017年12月12日15:11:09
    * Angela
    * 访问权限
    */
    public function error(){
        $errorMessage = [
            'code'=>404,
            'message'=>'404 not found',
            // 处理表格数据展示
            'data'=>[],'draw'=>1,
            'recordsFiltered'=>1,
            'recordsTotal'=>1
        ];
        if(isAjax()){
            return die(json_encode($errorMessage));
        }else{
            return $this->display('error.html',$errorMessage); 
        }
    }
}
