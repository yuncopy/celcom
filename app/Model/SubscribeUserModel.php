<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Model;
use App\Model\SubscribeModel;
class SubscribeUserModel extends EloquentModel{
    
    public $timestamps = false;
    protected $table = 'tb_subscribe_user';
    protected $connection = 'subscribe';

    /**
     * 2017年11月28日17:13:39
     * Angela
     * 添加数据/更新数据
     */
    public function getSubscribe($msisdn,$pass){
        if($msisdn && $pass){
            $subscribe = $this->where('msisdn', $msisdn)->where('short_code', $pass)->where('status', 'A')->first();
            return !empty($subscribe) ? $subscribe->toArray() :  null;
        }
        return false;
    }
    
    
    /**
     * 检查是否登录
     */
     public function checkLogin($msisdn,$pwd=null){
       $msisdn = '+60'.$msisdn;
       $islogin = null;
       if($msisdn && $pwd){
           $login =  $this->where('msisdn', $msisdn)->where('short_code',$pwd)->where('status','A')->first();
           $islogin = true;
       }else if($msisdn && !$pwd){
           $login =  $this->where('msisdn', $msisdn)->where('status','A')->first();
       }
       if($login){
           if($islogin){ (new SubscribeModel())->setSpTransID($msisdn,$pwd);}  // 设置SpTransID
           return $login->toArray();
       }
       return false;
    }
   
    
}
