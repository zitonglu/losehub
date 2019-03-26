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

if (isset($_POST['send'])) {
	if (isset($_POST['comments']) && $_POST['comments'] == 'on') {
		$p_c_state_code = 'P';
	}else{
		$p_c_state_code = 'C';
	}
	if (isset($_POST['id']) && $_POST['id'] != '') {
		$query = "replace into ".LH_DB_PREFIX.'paragraphs'." (";
		$query .= "`p_contect`,`p_state_code`,`p_type_code`,`p_c_state_code`,`id`";
		$query .= ") values (";
		$query .= "'".$_POST['textarea']."','".$_POST['state']."','".$_POST['type']."','".$p_c_state_code."'".",".$_POST['id'];
		$query .= ")";
	}else{
		$query = "insert into ".LH_DB_PREFIX.'paragraphs'." (";
		$query .= "`p_contect`,`p_state_code`,`p_type_code`,`p_c_state_code`";
		$query .= ") values (";
		$query .= "'".$_POST['textarea']."','".$_POST['state']."','".$_POST['type']."','".$p_c_state_code."'";
		$query .= ")";
	}
	// echo $query;
	$dbn->exec($query);
	redirect($lh['site_url'].'/lh-admin/edit.php?id='.$dbn->lastInsertId());
}else{
	redirect($lh['site_url'].'/lh-admin/index.php');
}
?>
