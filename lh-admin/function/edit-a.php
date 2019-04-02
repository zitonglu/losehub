<?php
/**
 * LoseHub CMS 段落处理函数
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var $dbn,$lh
 * @version 2019-3-26
 * 
 * @return edit.php?id=
 */
require_once('base.php');
require_once('authorize.php');

if (isset($_POST['new'])) {
	if (isset($_POST['Aid']) === true) {
		$query = "replace into ".LH_DB_PREFIX.'articles'." (a_title,a_state_code,a_c_state_code,a_type_code) values ('".$_POST['title']."','P','C','P')";
	}else{
		$query = "insert into ".LH_DB_PREFIX.'articles'." (a_title,a_state_code,a_c_state_code,a_type_code) values ('".$_POST['title']."','P','C','P')";
	}
	echo $query;
	$dbn->exec($query);
	// 返回判断
	switch ($_POST['return']) {
		case 'alist':
			redirect($lh['site_url'].'/lh-admin/p-list.php');
			break;
		
		default:
			redirect($lh['site_url'].'/lh-admin/edit-article.php?id='.$dbn->lastInsertId().'&return=OK');
			break;
	}
}

?>