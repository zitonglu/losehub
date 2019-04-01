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
$total = 1;
// 获取总行数
if (isset($_GET['listselect'])) {
	$results_per_page = (int)$_GET['listselect'];// 翻页行数
	$query = MySQL_options_change('row_number',$results_per_page,LH_DB_PREFIX.'options');
	$dbn->query($query);
}else{
	$results_per_page = $lh['row_number'];
}

$cur_page = isset($_GET['page']) ? $_GET['page'] : 1;// 当前页面数
$skip = ($cur_page-1) * $results_per_page;// 计算上一页行数
$page_link = '';

$search_query = "SELECT * FROM ".LH_DB_PREFIX.'paragraphs';
// WHERE 条件
if(isset($_GET['state']) && isset($_GET['type'])){
	$search_query .= ' WHERE `state_code`='.$_GET['state'];
	echo $search_query;
}elseif (isset($_GET['state'])) {
	# code...
}
// 查询排序，生降序调整 ORDER BY
if (isset($_GET['orderby'])) {
	$orderbys = explode("-", $_GET['orderby']);
	$orderby = reset($orderbys);
	if (next($orderbys) == 'ASC') {
		$order = 'DESC';
	}else{
		$order = 'ASC';
	}

    // 增加SQL的ORDER BY
	switch ($orderby) {
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
	$search_query .= $order;
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

	$total ++;// 获取总行数-这是错的哦，要更换！
}
$num_page = ceil($total/$results_per_page);

include('header.php');
include('nav.php');
?>
<div class="container p-list">
	<div class="table-responsive">
	<table class="table table-striped table-hover list-table">
		<caption><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 段落列表 <a href="edit.php" title="新建"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> 新建</a></caption>
		<thead>
			<tr><?php
			$ths = array(
				'id' => '#',
				'type' => '类别',
				'1' => '内容',
				'state' => '状态',
				'cstate' => '评论',
				'time' => '时间'
			);
			foreach ($ths as $key => $value) {
				if ($key == '1') {
					echo '<th class="p-contect text-center">内容</th>';
				}else{
					if (isset($order) && $order == 'DESC') {
						echo '<th><a href="'.changeURLGet('orderby',$key.'-DESC').'">'.$value.'</a></th>';
					}else{
						echo '<th><a href="'.changeURLGet('orderby',$key.'-ASC').'">'.$value.'</a></th>';
					}
				}
			}
			?>
				<th class="text-right">归属</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php echo $echo;?>
		</tbody>
	</table>
	</div>
	<div class="col-sm-5">
	<nav aria-label="Page navigation">
		<ul class="pagination">
			<?php 
			if( $cur_page > 1){
				$page_link .= '<li><a href="#">1</a></li>';				
			}else{
				$page_link .= '<li><a href="" aria-label="Previous">';
				$page_link .= '<span aria-hidden="true">&laquo;</span>';
				$page_link .= '</a></li>';
			}

			for ($i=1; $i <= $num_page; $i++) { 
				if ($num_page == $i) {
					$page_link .= ''.$i;
				}else{
					$page_link .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=2">1</a></li>';
				}
			}
			if ($cur_page < $num_page) {
				$page_link .= '<li><a href="">2</a></li>';
			}else{
				$page_link .= '<li><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}
			echo $page_link;
			?>
			
		</ul>
	</nav>
	</div>
	<div class="col-sm-7">
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
			显示条数:
			<select class="form-control selectbox" name="list" onchange="window.location=this.value;" title="显示条数">
				<option value="<?php echo getPageURL();?>">显示行</option>
				<?php
					$listArray =array('5','10','15','20','30','50');
					foreach ($listArray as $key => $value) {
						if (@$value == $_GET['listselect']) {
							$checked = ' selected = "selected"';
						}else{
							$checked ='';
						}
						echo '<option value="'.changeURLGet('listselect',$value).'"'.$checked.'>'.$value.'</option>';
					}
				?>
			</select>
			状态：
			<select class="form-control selectbox" name="state" onchange="window.location=this.value;">
				<option value="<?php echo changeURLGet('state','0');?>">状态</option>
				<?php foreach ($states as $key => $value) {
					if (@$key == $_GET['state']) {
						$checked = ' selected = "selected"';
					}else{
						$checked ='';
					}
					echo '<option value="'.changeURLGet('state',$key).'"'.$checked.'>'.$value.'</option>';
				}
				?>
			</select>
			类别：
			<select class="form-control selectbox" name="type" onchange="window.location=this.value;">
				<option value="<?php echo changeURLGet('type','0');?>">类别</option>
				<?php foreach ($types as $key => $value) {
					if (@$key == $_GET['type']) {
						$checked = ' selected = "selected"';
					}else{
						$checked ='';
					}
					echo '<option value="'.changeURLGet('type',$key).'"'.$checked.'>'.$value.'</option>';
				}
				?>
			</select>
			<!-- <button type="submit" class="btn btn-default">提交</button> -->
		</form>
	</div>
</div>
<?php include('footer.php');?>