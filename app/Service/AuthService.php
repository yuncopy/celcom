<?php
/**
 * 2017年11月24日12:03:25
 * Angela 
 * 功能:AOC界面处理
 * 
 * 参考资料
 * http://code.mixmedia.com/resource-permission-rule/
 * http://php.net/manual/zh/language.operators.bitwise.php
 */
namespace App\Service;
use \Bramus\Router\Router;
use App\Model\AuthorityModel;
use App\Model\UsersModel;
class AuthService extends CommonService{
    
    private static $defalutAbtis = 1;
    /**
     * 2017年12月12日14:23:37
     * Angela
     * 是否有权限访问
     */
    static public function checkUserRule(){
        $userAbtis = self::getCurrentUserPermission();
        $urlAbtis = self::getCurrentURL();     
        $checkResult = self::checkPermission($userAbtis,$urlAbtis);
        return $checkResult;
    }




    /**
     * 2017年12月12日14:19:50
     * Angela 
     * 获取当前用户的资源（权限）列表
     */
    static public function getCurrentUserPermission() {
        $Authority = new AuthorityModel();
        $defalutAbtis = self::$defalutAbtis;    // 默认全部角色可以访问游戏列表
        $resAbtis = $Authority->getAbtis();  // 当前用户十进制
        if($resAbtis){
            $count_array = count($resAbtis);
            for ($i=1; $i < $count_array;$i++){
                $defalutAbtis |= (int)$resAbtis[$i];
            }
            $userAbtis = (int)$defalutAbtis;    // 当前用户按位 | 值
        }
        return self::mDecbin($userAbtis);
    }
    
   
    /**
     * 2017年12月11日18:26:43
     * Angela 
     * @return string 获取当前URL十进制转二进制值
     */
    static public function getCurrentURL() {
        $router = new Router();
        $method = $router->getRequestMethod(); // 获取当前访问方法
        $uri = self::call_private_method( $router ,'getCurrentUri');  // 访问当前URL
        $re_uri = preg_replace("/[0-9]+/", '*', $uri);  // 入库时约定     
        // 查询数据库中对应十进制
        $where=[
            'route' =>  $re_uri,
            'method'=>  $method 
        ];
        $Authority = new AuthorityModel();
        $resAuthURL = $Authority->getoneAuth($where);  // 当前URL十进制
        if($resAuthURL){
            $urlAbtis = (int)$resAuthURL['abits'];  // 当前URL的十进制
        }
        return isset($urlAbtis) ? self::mDecbin($urlAbtis) : null;  // 二进制
    }
    
  
    
    /**
     * 2017年12月9日19:03:10
     * Angela
     * 十进制转二进制
     * @param int $numberDec 十进制
     * @return int 二进制
     */
    
    static public function mDecbin($numberDec){
        return decbin($numberDec);
    }



    /**
     * 获取资源列表
     * @param string $user 用户权限 
     * @param string $permission 访问资源标识
     * @return bool
     *  权限规则	十进制	二进制
     *  新建会员	1	1
     *  删除会员	2	10
     *  新建产品	4	100
     *  合并规则	7	111
     *  111 = 1 | 10 | 100 ;
     * “111”  &　“010” == “010” //判断是否获得“删除会员”权限
     */
    static public function checkPermission($user, $permission) {
        //获取最长字符长度
        $lengths = array_map('strlen', array($user, $permission));
        $count = max($lengths);
        //为不够长的字符串补位
        $rule = (string)str_pad($user, $count, '0', STR_PAD_LEFT);
        $resource = (string)str_pad($permission, $count, '0', STR_PAD_LEFT);
        if(($rule & $resource) == $resource) {
            return true;
        } else {
            return false;
        }
    }
    
      /**
     * 2017年12月11日18:21:23
     * Angela
     * 利用反射机制，访问私有方法
     */
    // http://php.net/manual/zh/reflectionmethod.getclosure.php  学习使用
    static public function call_private_method($object, $method, $args = array()) {
        $reflection = new \ReflectionClass(get_class($object));    //利用反射api构造一个 类对应的反射类  
        $closure = $reflection->getMethod($method)->getClosure($object);   //您可以使用getClosure调用私有方法 
       // $reflection->getMethod($method)  //获取该类 $method参数所指向的方法对象  
       // $reflection->getMethod($method)->getClosure($object);  
        return call_user_func_array($closure, $args);   // $closure(...$args);  等效
    }
    
   
}