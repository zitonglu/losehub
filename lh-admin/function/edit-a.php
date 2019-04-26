<?php
/**
 * LoseHub CMS 文章处理函数
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var $dbn,$lh
 * @version 2019-4-8
 * 
 * @return edit-article.php?id=
 */
require_once('base.php');
require_once('authorize.php');

/**
 * 新建文章
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-4-18
 * 
 * @return edit-article.php OR Aid
 */
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

/**
 * 文章编辑
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-4-18
 * 
 * @return edit-article.php Aid return
 */
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

/**
 * 增加文章判断
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-4-18
 * 
 * @return edit-article.php Aid return
 */
if (@$_GET['return'] == 'addP') {
	$query = "UPDATE ".LH_DB_PREFIX.'paragraphs'." SET ";
	$query .= "`p_a_id` = '".$_GET['Aid']."'";
	$query .= " WHERE `id` = ".$_GET['id'];
	//echo $query;
	$dbn->exec($query);
	redirect($lh['site_url'].'/lh-admin/edit-article.php?Aid='.$_GET['Aid'].'&return=view');
}

/**
 * 增加文章标签
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;)
 * @version 2019-4-18
 * 
 * @return edit-article.php Aid return
 */

 if (isset($_POST['addTags'])) {
 	if (!empty($_POST['tags'])) {
 		$replace = str_replace('，',',',$_POST['tags']);
 		$replace = str_replace('-',',',$replace);
 		$replace = str_replace('、',',',$replace);
 		$inArrays = explode(',',$replace);//准备输入的数组

 		$query = 'SELECT `tag_name` FROM '.LH_DB_PREFIX.'tags'.' WHERE `tag_a_id` = '.$_POST['Aid'];
 		//echo $query;
 		$result = $dbn->query($query);
		$delArrays = $result->fetchAll(PDO::FETCH_COLUMN);
		foreach ($delArrays as $del) {
			arrayRemoveElement($inArrays,$del);//删除指定键值
		}
		//print_r($inArrays);
		foreach ($inArrays as $insert) {
		 	$query = 'INSERT INTO '.LH_DB_PREFIX.'tags'.' (`tag_name`, `tag_a_id`) values (';
		 	$query .= "'$insert',".$_POST['Aid'].')';
		 	$dbn->query($query);
		}				
 	}
 	redirect($lh['site_url'].'/lh-admin/edit-article.php?Aid='.$_POST['Aid'].'&return=view');
 }

?>