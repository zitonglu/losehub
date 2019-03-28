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
$addorder = '';

$search_query = "SELECT * FROM ".LH_DB_PREFIX.'paragraphs';
// 查询排序，生降序调整
if (isset($_GET['orderby'])) {
	switch ($_GET['orderby']) {
		case 'id':
		$search_query .= ' ORDER BY id ';
		break;
		case 'type':
		$search_query .= ' ORDER BY `p_type_code` ';
		break;
		case 'state':
		$search_query .= ' ORDER BY `p_state_code` ';
		break;
		case 'cstate':
		$search_query .= ' ORDER BY `p_c_state_code` ';
		break;
		case 'time':
		$search_query .= ' ORDER BY `p_datetime` ';
		break;
		default:
		break;
	}
	if (isset($_GET['by'])){
		$addorder = '';
		$search_query .= 'ASC';
	}else{
		$addorder = '&by=DESC';
		$search_query .= 'DESC';
	}
}

// echo $search_query;
$result = $dbn->prepare($search_query);
$result->execute();
$p_list = $result->fetchAll();

foreach ($p_list as $p_lists) {
	$echo .= '<tr>';
	$echo .= '<th scope="row">'.$p_lists['id'].'</th>';
	$echo .= '<td>'.get_type_name($p_lists['p_type_code']).'</td>';
	$echo .= '<td class="p-contect"><a href="#" class="ico"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a><a href="edit.php?id='.$p_lists['id'].'&return=plist" title="'.$p_lists['p_contect'].'"> '.$p_lists['p_contect'].'</a></td>';
	$echo .= '<td>'.get_state_name($p_lists['p_state_code']).'</td>';
	$echo .= '<td>'.get_state_name($p_lists['p_c_state_code']).'</td>';
	$echo .= '<td>'.substr($p_lists['p_datetime'],0,10).'</td>';
	if ($p_lists['p_a_id'] == 1) {
		$echo .= '<td class="text-right">无</td>';
	}else{
		$echo .= '<td class="text-right">'.$p_lists['p_a_id'].'- <span class="glyphicon glyphicon-sort-by-order" aria-hidden="true"></span> '.$p_lists['p_order'].'</td>';
	}
	$echo .= '<td><a href="edit.php?id='.$p_lists['id'].'&return=plist" title="编辑"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> ';
	$echo .= '<a href="deletedb.php?delid='.$p_lists['id'].'&return=plist" title="删除"><code><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></code></a></td>';
	$echo .= '</tr>';
}

include('header.php');
include('nav.php');
?>
<div class="container p-list">
	<table class="table table-striped table-hover list-table">
		<caption><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 段落列表 <a href="edit.php" title="新建"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> 新建</a></caption>
		<thead>
			<tr>
				<th><a href="?orderby=id<?php echo $addorder;?>">#</a></th>
				<th><a href="?orderby=type<?php echo $addorder;?>">类别</a></th>
				<th class="p-contect text-center">内容</th>
				<th><a href="?orderby=state<?php echo $addorder;?>">状态</a></th>
				<th><a href="?orderby=cstate<?php echo $addorder;?>">评论</a></th>
				<th><a href="?orderby=time<?php echo $addorder;?>">时间</a></th>
				<th class="text-right">归属</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php echo $echo;?>
		</tbody>
	</table>
</div>
<?php include('footer.php');?>