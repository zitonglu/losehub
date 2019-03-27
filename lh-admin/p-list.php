<?php
/**
 * LoseHub CMS 后台登录界面-段落列表界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;),$lh
 * @version 2019-3-27
 * 
 * @return none
 */
require_once('function/base.php');
require_once('function/authorize.php');

$echo = '';

$query = "SELECT `id`,`p_contect`,`p_state_code`,`p_c_state_code`,`p_type_code`,`p_datetime`,`p_a_id`";
$query .= " FROM ".LH_DB_PREFIX.'paragraphs';
// echo $query;
$result = $dbn->prepare($query);
$result->execute();
$p_list = $result->fetchAll();

foreach ($p_list as $p_lists) {
	$echo .= '<tbody><tr>';
	$echo .= '<th scope="row">'.$p_lists['id'].'</th>';
	$echo .= '<td>'.$p_lists['p_type_code'].'</td>';
	$echo .= '<td>'.$p_lists['p_contect'].'</td>';
	$echo .= '<td>'.$p_lists['p_state_code'].'</td>';
	if ($p_lists['p_c_state_code'] == 'P') {
		$echo .= '<td>可以评论</td>';
	}else{
		$echo .= '<td>不可评论</td>';
	}
	$echo .= '<td>'.substr($p_lists['p_datetime'],0,10).'</td>';
	$echo .= '<td>'.$p_lists['p_a_id'].'</td>';
	$echo .= '<td><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></td>';
	$echo .= '</tr></tbody>';
}

include('header.php');
include('nav.php');
?>
<div class="container p-list">
	<table class="table">
		<caption><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 段落列表</caption>
		<thead>
			<tr>
				<th>#</th>
				<th>类别</th>
				<th class="p-contect">内容</th>
				<th>状态</th>
				<th>评论</th>
				<th>发布时间</th>
				<th>归属长文</th>
				<th></th>
			</tr>
		</thead>
		<?php echo $echo;?>
	</table>
</div>
<?php include('footer.php');?>