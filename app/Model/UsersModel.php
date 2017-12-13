<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Model;
use LiveControl\EloquentDataTable\DataTable;
use App\Service\LoginService;
class UsersModel extends EloquentModel{
    
    public $timestamps = false;
    protected $table = 'users';


    /**
     * 2017年11月28日17:13:39
     * Angela
     * 添加数据/更新数据
     */
    public  function insertOrUpdate($data,$where=[]){
        if(!empty($data) && !empty($where)){
            return $this->where(function($query) use ($where){
                foreach ($where as $key => $value){
                    $query->where($key, $value);
                }
            })->update($data);
        }else{
            return $this->insertGetId($data);
        }
        return false;
    }
    
    /**
     * 2017年11月28日18:24:00
     * Angela
     * 验证用户
     * 
     */
    public  function checkLogin($name){
       $login =  $this->where('name', $name)->first();
       if($login){
           return $login->toArray();
       }
       return false;
    }
    
    
    /**
     * 2017年12月11日10:57:16
     * Angela
     * 删除数据
     */
    public function delOneUser($id){
        return $this->where('id', $id)->delete();
    }
    
    /**
     * 2017年12月11日11:16:44
     * Angela
     * 获取单条数据
     */
    public function getOne($id){
        return $this->where('id', $id)->first()->toArray();
    }

    

    /**
     * 2017年12月9日19:13:32
     * Angela
     * 获取数据
     */
    public  function getUserList(){
        $dataTable = new DataTable(
            $this,  // $this->where('active',1)
            ['id', 'name','auth_id','create_time','id']
        );
        return $dataTable;
    }
    
    
    /**
     * 2017年12月12日11:34:00
     * Angela
     * 获取当前用户权限ID值
     * 
     */
    public function getCurrentAbtis(){
        $userCookie = LoginService::getUserCookie();
        $uid = $userCookie['uid'];
        $uInfo = $this->getOne($uid);
        $auth_id = $uInfo['auth_id'];
        return explode(',', $auth_id);
    }


}
