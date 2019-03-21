<?php
/**
 * LoseHub CMS 授权函数
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var $dbn;
 * @version 2019-3-19
 * 
 * @return none or login.php
 */
// require_once('function/base.php');
require_once('function/authorize-header.php');

// 数据库连接
// try {
// $dbn = new PDO('mysql:host='.LH_DB_HOST.';dbname='.LH_DB_NAME,LH_DB_USER,LH_DB_PASSWORD);
// }catch (PDOException $e) {
// $echo = '<p class="text-danger text-center">Error!: ' . $e->getMessage() . '</p>';
// $echo .=  '<p class="text-danger text-center">无法链接数据库,请检查填写是否正确</p>';
// }
// 判断是否已是登录用户
if (isset($_COOKIE['lh_cookie_user']) && isset($_COOKIE['lh_cookie_password'])) {
	$query = "SELECT COUNT(*) FROM `".LH_DB_PREFIX.'ssh'."` WHERE `SSH_login` = ".$_COOKIE['lh_cookie_user']." AND `SSH_password` = SHA(".$_COOKIE['lh_cookie_password'].")";
}else{
	session_start();
	$query = "SELECT COUNT(*) FROM `".LH_DB_PREFIX.'ssh'."` WHERE `SSH_login` = ".$_SESSION['lh_session_userName']." AND `SSH_password` = SHA(".$_SESSION['lh_session_userPassWord'].")";
}
$count = $dbn->query($query);
if (!(is_object($count) && $count->fetchColumn()>0)) {
	$dbn = null;
	session_destroy();
  	setcookie("lh_cookie_password");
	redirect('login.php');
}

// session_destroy();
?>