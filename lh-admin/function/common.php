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

?>