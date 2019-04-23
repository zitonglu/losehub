<?php
/**
 * LoseHub CMS 删除段落及文章数据的函数
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var $dbn,$lh
 * @version 2019-4-17
 * 
 * @return back
 */
require_once('function/base.php');
require_once('function/authorize.php');

$echo = '';

switch ($_GET['return']) {
	case 'plist':// 返回查询的段落信息，改变return值
	$query = "SELECT `p_contect`,`p_state_code`,`p_type_code`,`p_datetime`";
	$query .= " FROM ".LH_DB_PREFIX.'paragraphs';
	$query .= " WHERE `id`=".$_GET['delid'];
	$sth = $dbn->prepare($query);
	$sth->execute();
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$echo = '您在'.$row['p_datetime'].'发表的\'段落\'，内容如下:<br />';
		$echo .= $row['p_contect'].'<br /><br /><br />';
		$echo .= '段落类别：'.get_type_name($row['p_type_code']);
		$echo .= ' 当前状态：'.get_state_name($row['p_state_code']);
	}

	$return_value = 'delP';
	$id_value = $_GET['delid'];
	break;
	
	case 'delP':// 确认删除段落并返回段落列表
	$query = "DELETE FROM ".LH_DB_PREFIX.'paragraphs';
	$query .= " WHERE `id`=".$_GET['id'];
	$sth = $dbn->exec($query);
	if ($sth == 1) {
		redirect($lh['site_url'].'/lh-admin/p-list.php?return=OK');
	}else{
		$echo = '<p>删除执行错误</p>';;
	}
	break;

	case 'alist':// 返回查询的文章信息，改变return值
	$query = "SELECT `a_title`,`a_state_code`,`a_type_code`,`a_datetime`";
	$query .= " FROM ".LH_DB_PREFIX.'articles';
	$query .= " WHERE `a_id`=".$_GET['delAid'];
	$sth = $dbn->prepare($query);
	$sth->execute();
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$echo = '您在'.$row['a_datetime'].'发表的\'文章\'，标题如下:<br /><h2>';
		$echo .= $row['a_title'].'</h2><br /><br />';
		$echo .= '文章类别：'.get_type_name($row['a_type_code']);
		$echo .= ' 文章状态：'.get_state_name($row['a_state_code']);
		$echo .= '<br><label><input type="checkbox" name="delAllP"> 是否同时删除所有段落。</label>';
	}

	$return_value = 'delA';
	$id_value = $_GET['delAid'];
	break;

	case 'delA':// 确认删除文章并返回段落列表
	if (@$_GET['delAllP'] == 'on') {
		$query = "DELETE FROM ".LH_DB_PREFIX.'paragraphs';
		$query .= " WHERE `p_a_id`=".$_GET['id'];
	}else{
		$query = "UPDATE ".LH_DB_PREFIX.'paragraphs'." SET ";
		$query .= "`p_a_id`= 1";
		$query .= " WHERE `p_a_id`=".$_GET['id'];
	}
	$sth = $dbn->exec($query);
	//echo $query;
	$query = "DELETE FROM ".LH_DB_PREFIX.'articles';
	$query .= " WHERE `a_id`=".$_GET['id'];
	$sth = $dbn->exec($query);
	if ($sth == 1) {
		redirect($lh['site_url'].'/lh-admin/a-list.php?return=OK');
	}else{
		$echo = '<p>删除执行错误</p>';
	}
	break;

	case 'optionDatabase':// 返回查询的预加载项信息，改变return值
	$query = 'SELECT * FROM '.LH_DB_PREFIX.'options';
	$query .= ' WHERE `option_code`=\''.$_GET['delOption'].'\'';
	$sth = $dbn->prepare($query);
	$sth->execute();
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$echo .= '<br><p>准备删除'.LH_DB_PREFIX.'options'.'表中如下信息：</p>';
		$echo .= '<p class="lead"><code>option_code</code>：'.$row['option_code'];
		$echo .= ' = <code>option_value</code>：'.$row['option_value'];
		$echo .= '</p><br>';
	}

	$return_value = 'delOption';
	$id_value = $_GET['delOption'];
	break;

	case 'delOption':// 确认删除预选项表的相应值
	$query = 'DELETE FROM '.LH_DB_PREFIX.'options';
	$query .= ' WHERE `option_code`=\''.$_GET['id'].'\'';
	$sth = $dbn->query($query);
	//echo $query;
	if ($sth == 1) {
		redirect($lh['site_url'].'/lh-admin/option-database.php?return=OK');
	}else{
		$echo = '<p>删除执行错误</p>';
	}
	break;

	case 'optionSSH':// 返回查询的密匙信息，改变return值
	$query = 'SELECT * FROM '.LH_DB_PREFIX.'ssh';
	$query .= ' WHERE `SSH_id`=\''.$_GET['SSHid'].'\'';
	$sth = $dbn->prepare($query);
	$sth->execute();
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$echo .= '<br><p>准备删除'.LH_DB_PREFIX.'ssh'.'表中如下信息：</p>';
		$echo .= '<p class="lead">登录“'.$row['SSH_name'].'”的帐号：'.$row['SSH_login'];
		$echo .= '。它的有效日期截止：'.$row['SSH_date'].'</p><br>';
	}

	$return_value = 'delSSH';
	$id_value = $_GET['SSHid'];
	break;

	case 'delSSH':// 确认删除预密匙的相应值
	$query = 'DELETE FROM '.LH_DB_PREFIX.'ssh';
	$query .= ' WHERE `SSH_id`=\''.$_GET['id'].'\'';
	$sth = $dbn->query($query);
	//echo $query;
	if ($sth == 1) {
		redirect($lh['site_url'].'/lh-admin/option-ssh.php?return=OK');
	}else{
		$echo = '<p>删除执行错误</p>';
	}
	break;

	default:
	$echo ='未能删除完成';
	break;
}


include('header.php');
include('nav.php');
?>
<div class="container">
	<div class="alert alert-danger alert-dismissible fade in" role="alert" id="myAlert">
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
			<h4>您确认删除数据库中如下信息吗？</h4>
			<p><?php echo $echo;?></p>
			<p>
				<input type="hidden" name="return" value="<?php echo $return_value;?>">
				<input type="hidden" name="id" value="<?php echo $id_value;?>">
				<button type="submit" class="btn btn-danger">是的，删除</button>
				<button type="button" class="btn btn-default" aria-label="Close" onclick="javascript:window.history.back(-1);">不，我考虑下</button>
			</p>
		</form>
	</div>
</div>

<?php include('footer.php');?>