<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Model;
use App\Model\UsersModel;
use LiveControl\EloquentDataTable\DataTable;
class AuthorityModel extends EloquentModel{
    
    public $timestamps = false;
    protected $table = 'authority';
    protected  $page_size = 16;

    
    /**
     * 获取所有权限
     */
    public function  getAuthoritys(){
        return $this->get()->toArray();
    }

    

    /**
     * 2017年11月25日17:05:35
     * Angela
     * 获取单条记录
     */
    
    public function getOne($id){
        return $this->where('id', $id)->first()->toArray();
    }
    
    /**
     * 2017年12月11日20:23:45
     * Angela
     * 获取单条记录
     * @param array $where 数组
     */
    public function getoneAuth($where){
        if(!empty($where) && is_array($where)){
            $res = $this->where(function ($query) use ($where){
                foreach ($where as $key => $value){
                    $query->where($key, $value);
                }
            })->first();
            //dd($res);
            return !empty($res) ? $res->toArray() : null;
        }
    }
    
    /*
     * 2017年12月9日17:30:07
     * Angela
     * 获取记录记录数
     */
    public function counts(){
        return $this->count();
    }

        /**
     * 2017年12月9日12:11:51
     * Angela
     * 删除单条数据
     */
    public function delOne($id){
        return $this->where('id', $id)->delete();
    }

    /**
     * 2017年12月8日14:29:32
     * Angela
     * 修改内容和添加
     */
    
    public function insertOrUpdate($data,$where=[]){
        if(!empty($data) && !empty($where)){
            return $this->where(function($query) use ($where){
                foreach ($where as $key => $value){
                    $query->where($key, $value);
                }
            })->update($data);
        }else if(!$where){
            return $this->insertGetId($data);
        }
        return false;
    }
    
    /**
     * 2017年12月8日17:38:25
     * Angela
     * 获取内容列表
     */
    public function getList(){
        // 手册 https://packagist.org/packages/livecontrol/eloquent-datatable
        $dataTable = new DataTable(
            $this,  // $this->where('active',1)
            ['id', 'name','create_time','abits','active','pid','method','route']
        );
        return $dataTable;
    }
    
    
    /**
     * 2017年12月12日11:40:25
     * Angela
     * 获取当前用户的十进制
     */
    public function getAbtis(){
        $abtis = (new UsersModel())->getCurrentAbtis();
        $userAbtis = $this->whereIn('id',$abtis)->get()->toArray();
        $abits_array = array_column($userAbtis, 'abits');  // 十进制
        return $abits_array;
    }
    
   
}
