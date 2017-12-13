<?php

/**
 * 首页控制
 * 2017年11月21日17:54:32
 * 
 */

namespace App\Controller;

use App\Model\ContentsModel;
use App\Model\SubscribeModel;
use App\Model\SubscribeUserModel;
use App\Service\AocService;
use App\Service\SubService;

class HomeController extends CommonController {

    /**
     * 2017年11月25日11:11:30
     * Angela
     * 显示首页
     */
    public function index($page) {
        //获取数据内容
        $list = $this->getContent('index', $page);
        $site = $this->wapsite;
        if($site == 'game/'){
            $cate = Config('cate');
            $list['cates']  =   $cate;
            $list['banner'] = array_slice($cate, 0, 4);
        }
        //dd($list);
        $this->display('index.html', $list);
    }

    /**
     * 获取内容
     * 2017年11月27日17:27:16
     * Angela 
     */
    public function getContent($action, $par, $page = 1) {
        $contents = new ContentsModel;
        $aoc = new AocService();
        switch ($action) {
            case 'index':
                $list = $contents->index($par);  //获取分页数据
                $data = $aoc->pushKey($list['data']); // 添加标识KEY
                $next_prev = $aoc->nextPreUrl($list); // 分页处理
                $list['data'] = $data;
                $list['next_page_url'] = $next_prev['next_page_url'];
                $list['prev_page_url'] = $next_prev['prev_page_url'];
                break;
            case 'category':
                $list = $contents->getCate($par);  // 获取分类数据
                $data = $aoc->pushKey($list['data']); // 添加标识KEY
                $next_prev = $aoc->nextPreUrl($list); // 分页处理
                $list['data'] = $data;
                $list['next_page_url'] = $next_prev['next_page_url'];
                $list['prev_page_url'] = $next_prev['prev_page_url'];
                break;
            case 'sorts':
                $sorts_field = [
                    '1' => 'created_at', // 最新
                    '2' => 'click'  // 最热
                ];
                $sort_field_name = $sorts_field[$par];
                $list = $contents->orderContent($sort_field_name, $page);  // 获取分类数据
                $data = $aoc->pushKey($list['data']); // 添加标识KEY
                $next_prev = $aoc->nextPreUrl($list); // 分页处理
                $list['data'] = $data;
                $list['next_page_url'] = '/sorts/' . $par . $next_prev['next_page_url'];
                $list['prev_page_url'] = '/sorts/' . $par . $next_prev['prev_page_url'];
                break;
        }
        $top = $contents->topVideo();  // 热门视频
        
        return ['list' => $list, 'top' => $top];
    }

    /**
     * 显示分类列表
     */
    public function category($cate) {
        
        $list = $this->getContent('category', $cate);
        $list['cates'] = $cate = Config('cate');
        $this->display('category.html', $list);
    }

   

    /**
     * 查看单条记录信息
     */
    public function singlepage($id) {

        // 是否成功订阅====start====
        $vip =  SubService::checkSub();
        // 是否成功订阅====end====
        $contents = new ContentsModel;
        $row = $contents->getOne($id);
        $top = $contents->topVideo();  // 热门视频
        $contents->incrClick($id);  //更新单击记录
        $row['thumb'] = hosts($row['thumb']);
        $row['seeds'] = hosts($row['seeds']);
        $subURL = subURL();
        $this->display('singlepage.html', ['id' => $id, 'row' => $row, 'top' => $top,'vip'=>$vip,'subURL'=>$subURL]);
    }

    /**
     * 联系我们
     * 2017年11月27日10:26:24
     * Angela
     */
    public function contact() {
        $contents = new ContentsModel;
        $top = $contents->topVideo();  // 热门视频
        $this->display('contact.html',['top'=>$top]);
    }

    /**
     * 排序使用
     * 2017年11月27日16:21:57
     * Angela
     */
    public function sorts($sorts, $page) {
        $list = $this->getContent('sorts', $sorts, $page);
        $this->display('index.html', $list);
    }

    //===========================订阅业务相关=====start========
    /**
     * 2017年11月23日16:01:10
     * Angela
     * 请求接口获取AOC界面地址
     * @param string/int $svid 业务ID
     * @param string $sessionid 渠道ID
     * @param string $jump 是否直接状态
     */
    public function celcom($svid, $sessionid,$jump) {
        if ($svid) {
            $data = [
                'svid'    =>    $svid,
                'session' =>    $sessionid
            ];
            SubService::getAndSetSubPara($data); // 设置请求地址
            if(!$sessionid){$sessionid = 123;}
            if($jump){ // 直接跳转
                $aoc_url = (new AocService())->getAoc($svid, $sessionid);
                return redirect($aoc_url);  // 跳转运营商AOC界面
            }
            return redirect('/');
            //$list = $this->getContent('index', 1);
            //$this->display('index.html', $list);
        }
    }

    /**
     * 2017年11月27日10:56:23
     * Angela
     * 
     * 订阅成功，重定向通知
     * 
     * @param string $status 状态通知
     * @param int $amount 订阅金额
     * @param int $msisdn 手机号
     * @param string $pwd 登录密码
     *   /callback/denied/70/60132665968/22
     */
    public function callback($status, $amount, $msisdn, $pwd ,$transID) {
        
        \Logs::info('callback',
            ['uri'=>"uri:{$_SERVER['REQUEST_URI']} || status:{$status} || amount:{$amount} || msisdn:{$msisdn} || pwd:{$pwd} || transID:{$transID}"]
        );
        if ($status == 'cancelled') {  // 订阅取消
            // TODO
            SubService::subLogout();
        }else if($status == 'denied'){  // 订阅失败
            // TODO
            SubService::subLogout();
        } else if($status == 'charged'){     // 订阅成功
            $subMsisdn = str_replace('+60', '', $msisdn);
            $result = SubService::subSuccess($subMsisdn, $pwd);  // 登录使用
            // 缓存spTransID
            SubService::spTransIDSetAndGet($transID);  // 退订时使用
            if($result){
                //数据库入库 
                $data = [
                    'msisdn'    =>  $msisdn,
                    'pwd'       =>  $pwd,
                    'status'    =>  $status,
                    'amount'    =>  $amount,
                    'sptransid' =>  $transID
                ];
                $id = (new SubscribeModel)->insertOrUpdate($data);
            }
        }else{
            // TODO
        }
        return redirect('/');  // 跳转
    }
    
    
    /**
     * 2017年12月13日13:11:49
     * Angela
     * 退订请求
     */
    public function unsub(){
        $spTransID = $this->getPostDatas('POST','spTransID',false,'trim');
        if($spTransID){
            $result = (new AocService)->unSub($spTransID);
            $status = $result['status'];
            if($status == 200){
                $message = 'Unsubscribe success';
            }else{
                $message = 'Unsubscribe failure';
            }
        }
        die(json_encode(['status'=>$status,'message'=>$message]));
    }

    

    /**
     * 2017年11月28日18:13:12
     * Angela
     * 登录验证
     */
    public function login(){
        $msisdn = $this->getPostDatas('POST','msisdn',false,'htmlspecialchars');
        $pwd = $this->getPostDatas('POST','pwd',false,'htmlspecialchars');
        $loginInfo = [];
        if($msisdn && $pwd){
           // $loginInfo  = (new SubscribeModel)->checkLogin($msisdn,$pwd);  // 本地
            $loginInfo  = (new SubscribeUserModel)->checkLogin($msisdn,$pwd);  // 订阅数据库
            if($loginInfo){
                $auto_login = $this->getPostDatas('POST','login',false,'htmlspecialchars');
                $result = SubService::subSuccess($msisdn, $pwd ,$auto_login);
                $loginInfo['status'] = 200;  // 成功
                $loginInfo['result'] = $result; 
            }else{
                $loginInfo['status'] = 400; // 失败
            }
        }else{
            $loginInfo['status'] = 400; // 失败
        }
        die(json_encode($loginInfo));
    }
    
    
    
    /**
     * 2017年11月30日16:08:27
     * Anegla
     * 退出操作
     */
    
    public function logout(){
        $reslut = SubService::subLogout();
        if($reslut){
           return redirect('/');
        }
    }

    /**
     * 2017年12月5日11:03:13
     * Angela
     * 设置设备标识
     */
    public function setDevice(){
        $deviceNo = $this->getPostDatas('POST','device',false,'trim');
        \Logs::info("deviceNo : {$deviceNo}");
        $device = Config('app.device');
        $redis = new \Redis();
        //$redis->set($device,$deviceNo);   //  
        $aa = $redis->get($device);   //  
        print_r($aa );
    }
    
    /**
     * 2017年12月5日11:03:42
     * Angela
     * 获取密码
     */
    
    public function getPass(){
        $msisdn = $this->getPostDatas('POST','msisdn',false,'htmlspecialchars');
        if($msisdn){
            $loginInfo  = (new SubscribeUserModel)->checkLogin($msisdn);  // 订阅数据库
            if($loginInfo){
                $loginInfo['status'] = 200;  // 成功
            }else{
                $loginInfo['status'] = 400; // 失败
            }
        }else{
            $loginInfo['status'] = 400; // 失败
        }
        die(json_encode($loginInfo));
    }

}
