<?php
/**
 * 2017年11月24日12:03:25
 * Angela 
 * 功能:AOC界面处理
 * 
 */
namespace App\Service;
use Curl\Curl;
class AocService extends CommonService{

    private $back_url =  'http://52.221.117.134:21801/callback';  // 订阅成功后重定向地址

    /**
     * 2017年11月24日16:50:281
     * Angela
     *获取AOC 请求地址
     * @param string $svid 业务ID ，在数据库指定
     * @param strin $sessionid  区分推广渠道ID
     */
    public function getAoc($svid,$sessionid){

        $backurl= $this->back_url;  // 订阅成功重定向地址
        $aoc_token_api = CELCOM_AOCTOKEN_API."{$svid}/{$sessionid}/".base64_encode($backurl);  // 请求地址
        $curl = new Curl();
        $json_result = $curl->get($aoc_token_api);
        \Logs::info('getAoc',['token_api'=>$aoc_token_api,'Result'=>$json_result]);
        $result = json_decode($json_result, true);
        $aocUrl = null;
        if($result['errorCode'] == '00'){
           $aocUrl =  $result['aocUrl'];
        }
        return $aocUrl;
    }
    
    /**
     * 退订
     */
    public function unSub($spTransID){
        $unsub_api = CELCOM_UNSUB_API.$spTransID;
        $curl = new Curl();
        $json_result = $curl->get($unsub_api);
        \Logs::info('unSub',['unsub_api'=>$unsub_api,'Result'=>$json_result]);
        return json_decode($json_result, true);
    }

        /**
     * 2017年11月25日15:11:10
     * Angela
     * @param array $data 需要处理的数组
     * @return array 数组
     */
    public function pushKey($data){
        $i = 0;
        return  array_map(function(&$vv) use(&$i){
            $vv['i'] = $i;$i++;
            $vv['thumb'] = hosts($vv['thumb']);
            $vv['imgurl'] = hosts($vv['imgurl']);
            $vv['seeds'] = hosts($vv['seeds']);
            return $vv;
        },$data);
    }

    
    /**
     * 处理上一页，下一页URL地址
     * 2017年11月25日15:42:45
     * Angela
     */
    
    public function  nextPreUrl($list){
        $prev_page = 1;
        $next_page_url = 'next_page_url';
        $prev_page_url = 'prev_page_url';
        $sign = '=';
        $next_page = trim(strstr($list[$next_page_url], $sign),$sign);
        if($list[$prev_page_url]){
            $prev_page = trim(strstr($list[$prev_page_url], $sign),$sign);
        }
        $next_prev[$prev_page_url] = "/{$prev_page}.html";
        $next_prev[$next_page_url] = !empty($next_page) ? "/{$next_page}.html" : "/".($prev_page+1).".html";  // 处理URL
        return $next_prev;
    }




    // http://php.net/manual/zh/reflectionmethod.getclosure.php  学习使用
    function call_private_method($object, $method, $args = array()) {
        $reflection = new \ReflectionClass(get_class($object));    //利用反射api构造一个 类对应的反射类  
        $closure = $reflection->getMethod($method)->getClosure($object);   //您可以使用getClosure调用私有方法 
        // $reflection->getMethod($method)  获取该类 $method参数所指向的方法对象  
        // $reflection->getMethod($method)->getClosure($object);  
        return call_user_func_array($closure, $args);   // $closure(...$args);  等效
    }
}