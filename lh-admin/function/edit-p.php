<?php
/**
 * LoseHub CMS 段落处理函数
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var $dbn,$lh
 * @version 2019-4-9
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
	// 判断是否有ID，传递
	if (isset($_POST['id']) && $_POST['id'] != '') {
		$query = "replace into ".LH_DB_PREFIX.'paragraphs'." (";
		$query .= "`p_contect`,`p_state_code`,`p_type_code`,`p_c_state_code`,`id`,`p_order`";
		$query .= ") values (";
		$query .= "'".$_POST['textarea']."','".$_POST['state']."','".$_POST['type']."','".$p_c_state_code."'".",".$_POST['id'].",".$_POST['p_order'];
		$query .= ")";
	}else{
		$query = "insert into ".LH_DB_PREFIX.'paragraphs'." (";
		$query .= "`p_contect`,`p_state_code`,`p_type_code`,`p_c_state_code`,`p_order`";
			if (isset($_POST['Aid'])) {//传递归属长文
				$query .= ",`p_a_id`) values (";
				$query .= "'".$_POST['textarea']."','P','P','P',".$_POST['p_order'].",".$_POST['Aid'];
			}else{
				$query .= ") values (";
				$query .= "'".$_POST['textarea']."','".$_POST['state']."','".$_POST['type']."','".$p_c_state_code."',".$_POST['p_order'];
		}
		$query .= ")";
	}
	// echo $query;
	$dbn->exec($query);
	// 返回判断
	switch ($_POST['return']) {
		case 'plist':
			redirect($lh['site_url'].'/lh-admin/p-list.php');
			break;
		case 'article':
			redirect($lh['site_url'].'/lh-admin/edit-article.php?return=view&id='.$dbn->lastInsertId()."&Aid=".$_POST['Aid']);
			break;
		
		default:
			redirect($lh['site_url'].'/lh-admin/edit.php?id='.$dbn->lastInsertId().'&return=OK');
			break;
	}
}

?>