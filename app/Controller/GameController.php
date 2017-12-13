<?php

/**
 * 首页控制
 * 2017年11月21日17:54:32
 */
namespace App\Controller;
use App\Service\SubService;
use App\Model\SubscribeUserModel;
use App\Model\SubscribeModel;
use App\Model\ContentsModel;
use App\Service\AocService;
class GameController extends CommonController{
    //put your code heindexre
    public function category($id)
    {
        
        // 类别列表
        if($id){
            $contents = new ContentsModel;
            $aoc = new AocService();
            $list = $contents->getCate($id);  // 获取分类数据
            $data = $aoc->pushKey($list['data']); // 添加标识KEY
            $next_prev = $aoc->nextPreUrl($list); // 分页处理
            $list['data'] = $data;
            $list['next_page_url'] = $next_prev['next_page_url'];
            $list['prev_page_url'] = $next_prev['prev_page_url'];
            $this->display('categoryone.html', compact('list'));
            
        }else{
            $cate = Config('cate');
            $list['cates']  =   $cate;
            $this->display('category.html',$list);
        }
       
    }
    
    // 排行版
    public function top($page=1)
    {
        $contents = new ContentsModel;
        $aoc = new AocService();
        $list = $contents->index($page,'click');  //获取分页数据
        $data = $aoc->pushKey($list['data']); // 添加标识KEY
        $next_prev = $aoc->nextPreUrl($list); // 分页处理
        $list['data'] = $data;
        $list['next_page_url'] = '/top/'.trim($next_prev['next_page_url'],'/');
        $list['prev_page_url'] = '/top/'.trim($next_prev['prev_page_url'],'/');
        $this->display('top.html', compact('list'));
    }
    
    
     /**
     * 2017年11月30日11:30:23
     * Angela
     * 专题页面
     * @param Int $id 记录ID
     */
    public function album(){
        
        $this->display('album.html');
    }
    
    
    /**
     * 2017年11月30日11:30:23
     * Angela
     * 详情页面
     * @param Int $id 记录ID
     */
    public function detail($id){
        $subVip = SubService::checkSub();
        
        $contents = new ContentsModel();
        $game = $contents->getOne($id);
        $contents->incrClick($id);  // 单击数
        $cate = Config('cate');
        $cate_name = array_column($cate, 'name' , 'id');
        $game['cate'] =  $cate_name[$game['cate_id']];
        $game['time'] = date('Y-m-d',strtotime($game['create_time']));
        $game['size'] = rand(10, 300);  // 随机，先这样拉
        $game['texts'] = htmlspecialchars_decode($game['texts']);
        $game['descs'] = htmlspecialchars_decode($game['descs']);
        $scenes = explode(',', $game['scenes']);
        $this->display('detail.html',['subVip'=>$subVip,'subURL'=> subURL(),'game'=>$game,'scenes'=>$scenes]);
    }
    
     /**
     * 2017年11月30日11:29:24
     * Angela
     * 检查用户状态
     * @param Int $id 记录ID
     */
    public function msisdn(){
       $msisdn_info = SubService::getSubMsisdn();  // 获取用户信息
       $msisdn = $msisdn_info['name'];
       $pass = $msisdn_info['info'];
       $msisdn = '+60'.$msisdn;
       $subscribe = (new SubscribeUserModel)->getSubscribe($msisdn,$pass); // 查实是否订阅
       if(!$subscribe){
            return SubService::subLogout();  // 取消订阅
            //return (new SubscribeModel)->insertOrUpdate(['mt_status'=>'N'],['msisdn'=>$msisdn]); // 本地库
       }else{
           die(json_encode($subscribe));
       }
    }

    /**
     * 2017年11月30日11:29:24
     * Angela
     * 下载使用
     * @param Int $id 记录ID
     */
    public function download($id){
        //$filename = 
        $contents = new ContentsModel();
        $contentInfo = $contents->getOne($id);
        $seeds = $contentInfo['seeds'];
        $filePath = filter_var($seeds, FILTER_VALIDATE_URL);
        if($filePath){  // 远程资源
            $file_exists = ($ch = curl_init($filePath)) ? @curl_close($ch) || true : false;
            if($file_exists){
                $mimetype = 'mime/type';
                $file = date('Ymd').'_'.basename($filePath);
                header('Content-Type: '.$mimetype );
                header('Content-Disposition: attachment; filename="' .$file. '"');//下载后的新文件名
                readfile_chunked($filePath);  // 下载文件
                exit; 
            }
        }else{
            $filename = __UPLOAD__.$seeds;  // 文件路径
            if (file_exists($filename)) {  // 本地资源
                $mimetype = 'mime/type';
                $file = date('Ymd').'_'.basename($filename);
                header('Content-Type: '.$mimetype );
                header('Content-Disposition: attachment; filename="' .$file. '"');//下载后的新文件名
                readfile_chunked($filename);  // 下载文件
                exit;
            }
        }
        return false;
    }
    
    //最新
    public function news($page){
        
        $contents = new ContentsModel;
        $aoc = new AocService();
        $list = $contents->index($page);  //获取分页数据
        $data = $aoc->pushKey($list['data']); // 添加标识KEY
        $next_prev = $aoc->nextPreUrl($list); // 分页处理
        $list['data'] = $data;
        $list['next_page_url'] = '/news/'.trim($next_prev['next_page_url'],'/');
        $list['prev_page_url'] = '/news/'.trim($next_prev['prev_page_url'],'/');
        $this->display('news.html', compact('list'));
    }
    
    
 
}
