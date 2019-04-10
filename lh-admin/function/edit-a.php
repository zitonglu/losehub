<?php
/**
 * LoseHub CMS 文章处理函数
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var $dbn,$lh
 * @version 2019-4-8
 * 
 * @return edit.php?id=
 */
require_once('base.php');
require_once('authorize.php');

//新建文章判断
if (isset($_POST['new'])) {
	if (isset($_POST['Aid']) && $_POST['Aid']!= null) {
		$query = "replace into ".LH_DB_PREFIX.'articles'." (a_title,a_state_code,a_c_state_code,a_type_code) values ('".$_POST['title']."','P','C','P')";
	}else{
		$query = "insert into ".LH_DB_PREFIX.'articles'." (a_title,a_state_code,a_c_state_code,a_type_code) values ('".$_POST['title']."','P','C','P')";
	}
	//echo $query;
	$dbn->exec($query);
	//返回判断
	switch ($_POST['return']) {
		case 'alist':
			redirect($lh['site_url'].'/lh-admin/p-list.php');
			break;

		default:
			redirect($lh['site_url'].'/lh-admin/edit-article.php?Aid='.$dbn->lastInsertId().'&return=view');
			break;
	}
}

//文章编辑判断
if (isset($_POST['edit'])) {
	if (isset($_POST['comments']) && $_POST['comments'] == 'on') {
		$a_c_state_code = 'P';
	}else{
		$a_c_state_code = 'C';
	}
	$query = "replace into ".LH_DB_PREFIX.'articles'." (a_title,a_state_code,a_type_code,a_c_state_code,a_id) values ('";
	$query .= $_POST['title']."','".$_POST['state']."','".$_POST['type']."','".$a_c_state_code."',".$_POST['Aid'].")";
	//echo $query;
	$dbn->exec($query);
	switch ($_POST['return']) {
		case 'alist':
			redirect($lh['site_url'].'/lh-admin/p-list.php');
			break;

		default:
			redirect($lh['site_url'].'/lh-admin/edit-article.php?Aid='.$dbn->lastInsertId().'&return=view');
			break;
	}
}

?>