<?php
/**
 * LoseHub CMS 登录函数
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var $dbn;$tableName
 * @version 2019-3-16
 * 
 * @return none
 */
$lh_login_name = '';
$lh_login_password = '';

try {
$dbn = new PDO('mysql:host='.LH_DB_HOST.';dbname='.LH_DB_NAME,LH_DB_USER,LH_DB_PASSWORD);
}catch (PDOException $e) {
$echo = '<p class="text-danger text-center">Error!: ' . $e->getMessage() . '</p>';
$echo .=  '<p class="text-danger text-center">无法链接数据库,请检查填写是否正确</p>';
}

session_start();
if (isset($_SESSION['lh_session_userName']) && isset($_SESSION['lh_session_userPassWord'])) {
	$sth = $dbn->prepare('SELECT COUNT(*) FROM ? WHERE `SSH_login` = ? AND `SSH_password` = SHA(?)');
	// $sth->bindParam(':name',$_SESSION['lh_session_userName']);
	// $sth->bindParam(':password',$_SESSION['lh_session_userPassWord']);
	$sth->execute(array(LH_DB_PREFIX.'ssh',$_SESSION['lh_session_userName'],$_SESSION['lh_session_userPassWord']));
	$sth->debugDumpParams();
	if ($sth) {
		echo '$sth is ture<br/>';
		print_r($sth->fetchAll()) ;
	}
	echo '<br/>'.$_SESSION['lh_session_userName'].'<br/>';
	echo $_SESSION['lh_session_userPassWord'].'<br/>';
}

?>