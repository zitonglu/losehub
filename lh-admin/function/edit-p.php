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
	// 上传文件
	if ($_FILES['screenshot']['error'] == 0) {
		move_uploaded_file($_FILES['screenshot']['tmp_name'], '../../lh-content/uploads/'.date('ymdhis').$_FILES['screenshot']['name']);
		$textarea = $lh['site_url'].'/lh-content/uploads/'.date('ymdhis').$_FILES['screenshot']['name'].'\r\n'.$_POST['textarea'];
		switch ($_FILES['screenshot']['type']) {
			case 'image/jpeg':
			case 'image/png':
			case 'image/tiff':
			case 'image/vnd.svf':
			case 'image/gif':
			case 'image/jp2':
			case 'image/jp2':
				$p_type_code = 'pic';
				break;
			case 'video/mp4':
			case 'video/mpeg':
			case 'video/3gpp':
				$p_type_code = 'V';
				break;
			default:
				$p_type_code = $_POST['type'];
				break;
		}
	}else{
		// $textarea = 'Error: '.$_FILES["screenshot"]["error"].'</br>';
		$textarea = $_POST['textarea'];
		$p_type_code = $_POST['type'];
	}
	// 判断是否有ID，传递
	if (isset($_POST['id']) && $_POST['id'] != '') {
		$query = "replace into ".LH_DB_PREFIX.'paragraphs'." (";
		$query .= "`p_contect`,`p_state_code`,`p_type_code`,`p_c_state_code`,`id`,`p_order`";
		$query .= ") values (";
		$query .= "'".$textarea."','".$_POST['state']."','".$p_type_code."','".$p_c_state_code."'".",".$_POST['id'].",".$_POST['p_order'];
		$query .= ")";
	}else{
		$query = "insert into ".LH_DB_PREFIX.'paragraphs'." (";
		$query .= "`p_contect`,`p_state_code`,`p_type_code`,`p_c_state_code`,`p_order`";
		$query .= ") values (";
		$query .= "'".$textarea."','".$_POST['state']."','".$p_type_code."','".$p_c_state_code."',".$_POST['p_order'];
		$query .= ")";
	}
	// echo $query;
	$dbn->exec($query);
	// 返回判断
	switch ($_POST['return']) {
		case 'plist':
			redirect($lh['site_url'].'/lh-admin/p-list.php');
			break;
		
		default:
			redirect($lh['site_url'].'/lh-admin/edit.php?id='.$dbn->lastInsertId().'&return=OK');
			break;
	}
}else{
	redirect($lh['site_url'].'/lh-admin/index.php');
}
?>
