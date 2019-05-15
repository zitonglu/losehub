<?php
/**
 * LoseHub CMS 创建管理RSS函数
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var $dbn,$lh
 * @version 2019-5-15
 * 
 * @return rss-list.php
 */
require_once('base.php');
require_once('authorize.php');

/**
 * 新建RSS源
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-5-15
 * 
 * @return rss-list.php
 */
if (isset($_POST['create'])) {
	$url = str_replace(array('http://','//','https://'),'',$_POST['RSSURl']);
	echo $url;

	//echo $query;
	// $dbn->exec($query);
	//返回判断
	switch ($_POST['returnZZZZZ']) {
		case 'rss-list':
			redirect($lh['site_url'].'/lh-admin/rss-list.php?RSSid='.$dbn->lastInsertId());
			break;

		default:
			redirect($lh['site_url'].'/lh-admin/rss-list.php');
			break;
	}
}


?>