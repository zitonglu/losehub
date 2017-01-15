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
 * 用户登录验证函数
 * @author 紫铜炉 910109610@QQ.com
 * @version 2017-1-15
 * 
 * @return TRUE/FALSE
 */
function editUser(){
	global $LH_dataBase;
	$tableName = $LH_dataBase['dbprefix'].'user';

	try {
	$dsn = 'mysql:host='.$LH_dataBase['dbhost'].';dbname='.$LH_dataBase['dbname'];
	$dbh = new PDO($dsn,$LH_dataBase['dbuser'],$LH_dataBase['dbpass']);
	}catch (PDOException $e) {
	echo '<p class="text-danger text-center">Error!: ' . $e->getMessage() . '</p>';
	echo '<p class="text-danger text-center">无法链接数据库,请检查填写是否正确</p>';
	}

	if (isset($_COOKIE['LH_cookie_user'])) {
		$userName = $_COOKIE['LH_cookie_user'];
	}else{
		setcookie("LH_cookie_user");
		return FALSE;
	}

	$query = "SELECT COUNT(*) FROM `".$tableName."` WHERE ";
	$query .= "`user_login` = '".$userName."'";
	$count = $dbh->query($query);
	if ($count->fetchColumn() > 0) {
		return TRUE;
	}else{
		return FALSE;
	}
}

?>