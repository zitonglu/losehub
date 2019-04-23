<?php
/**
 * LoseHub CMS 授权函数
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var sssion
 * @global base.php($dbn;)
 * @version 2019-3-19
 * @return none or login.php
 */
// require_once('function/base.php');
require_once('authorize-header.php');

// 判断是否已是登录用户
if (isset($_COOKIE['lh_cookie_user']) && isset($_COOKIE['lh_cookie_password'])) {
	$query = "SELECT COUNT(*) FROM `".LH_DB_PREFIX.'ssh'."` WHERE `SSH_login` = '".$_COOKIE['lh_cookie_user']."' AND `SSH_password` = SHA('".$_COOKIE['lh_cookie_password']."'')";
}else{
	session_start();
	$query = "SELECT COUNT(*) FROM `".LH_DB_PREFIX.'ssh'."` WHERE `SSH_login` = '".$_SESSION['lh_session_userName']."' AND `SSH_password` = SHA('".$_SESSION['lh_session_userPassWord']."')";
}
//echo $query;
$count = $dbn->query($query);
if (!(is_object($count) && $count->fetchColumn()>0) || @$_GET['act'] == 'loginout'){
	$dbn = null;
	session_destroy();
  	setcookie("lh_cookie_password");
	redirect('login.php?error=1');
}

// session_destroy();
?>