<?php
/**
 * LoseHub CMS 删除数据段落及文章函数
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var $dbn,$lh
 * @version 2019-3-28
 * 
 * @return back
 */
require_once('function/base.php');
require_once('function/authorize.php');

$echo = '';

if($_GET['delid']) {
	switch ($_GET['return']) {
		// 返回查询的段落信息，改变return值
		case 'plist':
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

		$return_value = 'delp';
		$delid_value = $_GET['delid'];
		break;
		// 确认删除段落并返回段落列表
		case 'delp':
			$query = "DELETE FROM ".LH_DB_PREFIX.'paragraphs';
			$query .= " WHERE `id`=".$_GET['delid'];
			$sth = $dbn->exec($query);
  			if ($sth == 1) {
				redirect($lh['site_url'].'/lh-admin/p-list.php?return=OK');
			}else{
				$return_value = 'error';;
			}
		break;
		default:
			$echo ='未能删除完成';
		break;
	}
}

include('header.php');
include('nav.php');
?>
<div class="container">
	<div class="alert alert-danger alert-dismissible fade in" role="alert" id="myAlert">
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
		<!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> -->
			<h4>您确认删除数据库中如下信息吗？</h4>
			<p><?php echo $echo;?></p>
			<p>
				<input type="hidden" name="return" value="<?php echo $return_value;?>">
				<input type="hidden" name="delid" value="<?php echo $delid_value;?>">
				<button type="submit" class="btn btn-danger">是的，删除</button>
				<button type="button" class="btn btn-default" aria-label="Close" onclick="javascript:window.history.back(-1);">不，我考虑下</button>
			</p>
		</form>
	</div>
</div>

<?php include('footer.php');?>