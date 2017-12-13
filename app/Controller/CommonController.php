<?php

/**
 * 基础控制器
 */
namespace App\Controller;
use App\Service\SubService;
use App\Service\LoginService;
class CommonController{
    
    private $global_data = [];
    protected $wapsite = 'game/';
    public function __construct()
    {
        $global = SubService::getSubMsisdn();
        $global['subURL'] = subURL();
        $global['spTransID'] = spTransID();
        $global['apps']   =   Config('app');
        $this->global_data = $global;
        // 目前先这样定义了  后期改进 2017年12月1日15:49:25
        $uri_array = explode('/',pathinfo($_SERVER['REQUEST_URI'],PATHINFO_DIRNAME));
        $site = $uri_array['1'];
        if($site == 'file' || $site== 'login'){  
            $this->wapsite = 'file/'; // 后台模板，路径
            $global = LoginService::getUserCookie();
            $this->global_data = $global;
        }
    }
    
   /**
    * 
    * 渲染一个视图模板, 并直接输出给请求端
    * @param unknown_type $view 视图文件
    * @param unknown_type $data 分配数据
    */
   public function display($view,$data=[]){
       if(is_array($data)){
            $view_path = __VIEW__.$this->wapsite; 
            $loader = new \Twig_Loader_Filesystem($view_path);
            $twig = new \Twig_Environment($loader, array(
                'cache' => __STROAGE__.'template/cache',
                'debug' => true
            ));
            if($this->global_data){
                $data = array_merge($data, $this->global_data);
            }
            echo $twig->render($view, $data);
       }
   }
   
   /**
     * 获取提交数据
     * @param string $method 请求方式
     * @param string $name 键名
     * @param string $default 默认值
     * @param string $func 处理值的回调函数
     * @return array
     */
    protected function getPostDatas($method = '',$name='', $default = '', $func = ''){
        $fromData = array();
        $methods = !empty($method) ? strtoupper($method):$method;
        switch ($methods){
            case "GET":
                $fromData = $_GET; //$_GET;
                break;
            case "POST":
                $fromData = $_POST; //$_POST;
                break;
            default:
                parse_str(file_get_contents('php://input'), $fromData);
                break;
        }
        if (!empty($name)) {
            $fromData = array_key_exists($name, $fromData) ? $fromData[$name] : $default;
            return empty($func) ? $fromData : call_user_func($func, $fromData);
        }
        return $fromData;
    }
}
