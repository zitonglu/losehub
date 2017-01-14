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

?>