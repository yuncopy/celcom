<?php

/**
 * 2017年11月21日14:22:43
 * Angela 
 * 功能 ： 定义公共函数
 */
/**
 * 2017年11月21日16:49:40
 * Angela 
 * 获取配置文件信息
 * @param null $name  Config('system.NetType');
 * @return string
 */
use App\Service\SubService;  
if (!function_exists('Config')) {

    function Config($name) {
        $array_conf = explode('.', $name);
        $file_name = array_shift($array_conf);
        $config_path = __CONFIG__ . "{$file_name}.php";
        if (is_file($config_path) && file_exists($config_path)) {
            $conf = include ($config_path);  // 包含文件
            $info = $conf;
            foreach ($array_conf as $v) {
                if (isset($info[$v])) {
                    $info = $info[$v];  // 重新更新变量值，因为循环程序没有结束，可以操作变量值
                }
            }
            return $info;
        }
    }

}

/**
 * 2017年11月21日16:49:40
 * Angela 
 * 获取配置文件信息
 * @param null $name  Config('system.NetType');
 * @return string
 */
if (!function_exists('hosts')) {

    function hosts($url) {
        return 'http://192.168.4.9:8811/resources/' . $url;
    }

}

/**
 * 2017年11月28日10:57:13
 * Angela 
 * 订阅请求URL
 * @param null $name  Config('system.NetType');
 * @return string
 */
if (!function_exists('subURL')) {
    function subURL() {
        $urlData = SubService::getAndSetSubPara(); // 设置请求地址
        if(!$urlData){  // 设置默认值
            $urlData = [
                'svid' => 'my002',
                'session' => '222',
                'jump' => '1'
            ];
        }
        $urlData['jump'] = '1';  // 单击跳转
        $subURL = implode('/', $urlData); // 拼接跳转地址
        return $subURL;
    }
}

/**
 * 2017年12月13日12:19:57
 * Angela
 * 退订使用
 */
if (!function_exists('spTransID')) {
    function spTransID(){
       return SubService::spTransIDSetAndGet();
    }
}



//========================自定义=====================


// 形成树状结构
if (!function_exists('make_to_tree')) {
    /*
     * 二数组形成树状结构
     * @param $arr 操作数组
     * @param $parent_id 顶级父ID
     * @param $parent_name 顶级父字段名
     * @param $primary_key 主键
     * return void
     */
    function make_to_tree($arr, $parent_id = 0, $parent_name = "pid", $primary_key = "id") {
        $new_arr = array();
        foreach ($arr as $k => $v) {
            if ($v[$parent_name] == $parent_id) {
                $new_arr[] = $v;
                unset($arr[$k]);
            }
        }
        foreach ($new_arr as &$a) {
            $a['children'] = make_to_tree($arr, $a[$primary_key]);
        }
        return $new_arr;
    }

}
if (!function_exists('make_tree_with_namepre')) {
    function make_tree_with_namepre($arr)
    {
        $arr = make_to_tree($arr);
        if (!function_exists('add_namepre1')) {
            function add_namepre1($arr, $prestr='') {
                $new_arr = array();
                foreach ($arr as $v) {
                    if ($prestr) {
                        if ($v == end($arr)) {
                            $v['name'] = $prestr.'└─ '.$v['name'];
                        } else {
                            $v['name'] = $prestr.'├─ '.$v['name'];
                        }
                    }

                    if ($prestr == '') {
                        $prestr_for_children = '　 ';
                    } else {
                        if ($v == end($arr)) {
                            $prestr_for_children = $prestr.'　　 ';
                        } else {
                            $prestr_for_children = $prestr.'│　 ';
                        }
                    }
                    $v['children'] = add_namepre1($v['children'], $prestr_for_children);

                    $new_arr[] = $v;
                }
                return $new_arr;
            }
        }
        return add_namepre1($arr);
    }
}
 

if (!function_exists('make_option_tree_for_select')) {
    /**
     * @param $arr
     * @param int $depth，当$depth为0的时候表示不限制深度
     * @return string
     */
    function make_option_tree_for_select($arr, $depth=0)
    {
        $arr = make_tree_with_namepre($arr);
        if (!function_exists('make_options1')) {
            function make_options1($arr, $depth, $recursion_count=0, $ancestor_ids='') {
                $recursion_count++;
                $str = '';
                foreach ($arr as $v) {
                    $disabled='';
                    if ($v['pid'] == 0) {
                        $recursion_count = 1;
                    }else{
                        //$disabled = 'disabled = disabled';
                    }
                    $str .= "<option value='".$v['id']."' {$disabled}  data-depth='{$recursion_count}' data-ancestor_ids='".ltrim($ancestor_ids,',')."'>{$v['name']}</option>";
                    
                    if ($depth==0 || $recursion_count<$depth) {
                        $str .= make_options1($v['children'], $depth, $recursion_count, $ancestor_ids.','.$v['id']);
                    }
                }
                return $str;
            }
        }
        return make_options1($arr, $depth);
    }
}

/**
 * 将树状结构转化为列表
 * @param array $arr 数组
 */
if(!function_exists('make_tree_to_list')){
    function make_tree_to_list($arr){
        $new_arr = array();
        foreach($arr as $k=>$v){
            $new_arr[] = $v; 
            if(is_array($v['children']) && !empty($v['children'])){
               $bb = make_tree_to_list($v['children']);
               $new_arr = array_merge($new_arr,  $bb);
            }
        }
        return $new_arr;
    }
}




/**
 * 简单对称加密算法之加密
 * @param String $string 需要加密的字串
 * @param String $skey 加密EKY
 * @author Anyon Zou <zoujingli@qq.com>
 * @date 2013-08-13 19:30
 * @update 2014-10-10 10:10
 * @return String
 */
if (!function_exists('encode')) {

    function encode($string = '', $skey = 'cxphp') {
        $strArr = str_split(base64_encode($string));
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value)
            $key < $strCount && $strArr[$key] .= $value;
        return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
    }

}
/**
 * 简单对称加密算法之解密
 * @param String $string 需要解密的字串
 * @param String $skey 解密KEY
 * @author Anyon Zou <zoujingli@qq.com>
 * @date 2013-08-13 19:30
 * @update 2014-10-10 10:10
 * @return String
 */
if (!function_exists('decode')) {

    function decode($string = '', $skey = 'cxphp') {
        $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value)
            $key <= $strCount && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
        return base64_decode(join('', $strArr));
    }

}
/**
 * 分片下载文件
 * @param String $filename 文件名
 * @param String $retbytes 需要分多大下载
 * @return String
 */
if (!function_exists('readfile_chunked')) {

    function readfile_chunked($filename, $retbytes = TRUE) {
        $buffer = '';
        $cnt = 0;
        $handle = fopen($filename, 'rb');
        if ($handle === false) {
            return false;
        }
        while (!feof($handle)) {
            $buffer = fread($handle, 1024 * 1024);
            echo $buffer;
            ob_flush();
            flush();
            if ($retbytes) {
                $cnt += strlen($buffer);
            }
        }
        $status = fclose($handle);
        if ($retbytes && $status) {
            return $cnt; // return num. bytes delivered like readfile() does.
        }
        return $status;
    }

}

/**
 * 重定向浏览器到指定的 URL   
 * www.jbxue.com
 * @param string $url 要重定向的 url   
 * @param int $delay 等待多少秒以后跳转   
 * @param bool $js 指示是否返回用于跳转的 JavaScript 代码   
 * @param bool $jsWrapped 指示返回 JavaScript 代码时是否使用 <script type="text/javascript"></script>
  标签进行包装
 * @param bool $return 指示是否返回生成的 JavaScript 代码   
 */
if (!function_exists('redirect')) {

    function redirect($url, $delay = 0, $js = false, $jsWrapped = true, $return = false) {
        $delay = (int) $delay;
        if (!$js) {
            if (headers_sent() || $delay > 0) {
                echo '<html><head><meta http-equiv = "refresh" content = "' . $delay . ";URL=" . $url . '" /></head></html >';
                exit;
            } else {
                header("Location: {$url}");
                exit;
            }
        }

        $out = '';
        if ($jsWrapped) {
            $out .= '<script  type="text/javascript">';
        }
        $url = rawurlencode($url);
        if ($delay > 0) {
            $out .= "window.setTimeOut(function () { document.location='{$url}'; }, {$delay});";
        } else {
            $out .= "document.location='{$url}';";
        }
        if ($jsWrapped) {
            $out .= '</script>';
        }

        if ($return) {
            return $out;
        }
        echo $out;
        exit;
    }

}


/** 
 * 2017年12月12日15:25:41
 * Angela
 *@todo: 判断是否为ajax 
 */   
if(!function_exists('isAjax')){  
    function isAjax(){  
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH'])=='XMLHTTPREQUEST'){
            return true;
        }else{
            return false;
        }
    }  
}  



