<?php
/**
 * LoseHub CMS 辅助通用函数
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2017-1-14
 * 
 * @return none
 */

/**
 * 跳转函数，直接跳转到对应的URL地址
 * @var $url
 * @author 紫铜炉 910109610@QQ.com
 * @version 2017-1-14
 * 
 * @return URL
 */
function redirect($url){
	$url = str_replace(array('\n','\r'),'',$url);
	header('Location: ' . $url);
}
/**
 * 查找变量图片函数，查找变量中图片，返回链接地址的数组
 * @var $str
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-3-27
 * 
 * @return picUrlArray
 */
function get_http_img($str){
    $reg = '/((http|https):\/\/)+[\w\/\.\-]*(\w+\/)+(\w+)[\w\/\.\-]*(jpg|jpeg|gif|png)/';
    // $reg = '/((http|https):\/\/)+(\w+\/)+(\w+)[\w\/\.\-]*(jpg|gif|png)/';
    preg_match_all($reg, $str, $matches);
    foreach ($matches['0'] as $key => $value) {
        $picUrlArray[] = $value;
    }
    if (empty($picUrlArray)){
    	return array();
    }else{
    	return $picUrlArray;
    }
}
/**
 * 获取段落名称
 * @global $types
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-3-27
 * 
 * @return $value(type_name)
 */
function get_type_name($code){
    global $types;
    foreach ($types as $key => $value) {
         if ($code == $key) {
            return $value;
        }
    }
}
/**
 * 获取状态名称
 * @global $types
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-3-27
 * 
 * @return $value(states_name)
 */
function get_state_name($code){
    global $states;
    foreach ($states as $key => $value) {
         if ($code == $key) {
            return $value;
        }
    }
}

/**
 * 获取当前网址函数
 * @var $pageURL
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-3-28
 * 
 * @return $pageURL
 */
function getPageURL(){
    $pageURL = 'http'; 
    if (@$_SERVER["HTTPS"] == "on"){
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80"){
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }else{
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

/**
 * 获取当前网址函数-不含get值
 * @var $pageURL
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-3-28
 * 
 * @return $pageURL
 */
function getNoGetURL(){
    $pageURL = 'http'; 
    if (@$_SERVER["HTTPS"] == "on"){
        $pageURL .= "s";
    }
    $pageURL .= "://"; 
    $this_page = $_SERVER["REQUEST_URI"];   
// 只取 ? 前面的内容
    if (strpos($this_page, "?") !== false){
        $this_pages = explode("?", $this_page);
        $this_page = reset($this_pages);
    }
    if ($_SERVER["SERVER_PORT"] != "80"){
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $this_page;
    }else{
        $pageURL .= $_SERVER["SERVER_NAME"] . $this_page;
    }
    return $pageURL;
}
?>