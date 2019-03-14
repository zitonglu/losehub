<?php
/**
 * LoseHub CMS 授权函数-首部授权
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-3-14
 * 
 * @return header() or login.php
 */
if(isset($_GET['act']) || isset($_COOKIE['LH_cookie_user'])){
	$_SERVER['PHP_AUTH_USER'] = date("h");
}

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] != date("h")) {
	header('WWW-Authenticate: Basic realm="losehub"');
	header('HTTP/1.0 401 Unauthorized');
	include('./login.php');
	exit;
}else{
	header('Content-type:text/html; charset=utf-8');
}

?>