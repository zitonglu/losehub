<?php
/**
 * LoseHub CMS 后台界面-RSS源列表界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;),$lh
 * @version 2019-5-14
 * 
 * @return none
 */
require_once('function/base.php');
require_once('function/authorize.php');

$echo = '';

// 获取翻页相关信息
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

$search_query = "SELECT * FROM ".LH_DB_PREFIX.'rss';
$count_query = preg_replace('/\*/','count(*)',$search_query);//用于查询总行数

if($cur_page > 1){
	$i = (int)$results_per_page*($cur_page-1);
	$search_query .= $i.',';
}
$search_query .= $results_per_page;
// echo $search_query;
$result = $dbn->prepare($search_query);
$result->execute();
$p_list = $result->fetchAll();

$count = $dbn->query($count_query);
$counts = $count->fetch();
$total = $counts[0];// 获取总行数
$num_page = ceil($total/$results_per_page);// 分页数

foreach ($p_list as $p_lists) {
	$p_contect = preg_replace('/<\/?[^>]+>/i','',$p_lists['p_contect']);
	$echo .= '<tr>';
	$echo .= '<th scope="row">'.$p_lists['id'].'</th>';
	$echo .= '<td>'.get_type_name($p_lists['p_type_code']).'</td>';
	$echo .= '<td class="p-contect"><a href="#" class="ico"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a><a href="edit.php?id='.$p_lists['id'].'&return=plist" title="'.$p_contect.'"> '.$p_contect.'</a></td>';
	$echo .= '<td>'.get_state_name($p_lists['p_state_code']).'</td>';
	$echo .= '<td>'.get_state_name($p_lists['p_c_state_code']).'</td>';
	$echo .= '<td>'.substr($p_lists['p_datetime'],0,10).'</td>';
	if ($p_lists['p_a_id'] == 1) {
		$echo .= '<td class="text-right">无</td>';
	}else{
		$echo .= '<td class="text-right">'.$p_lists['p_a_id'].'</td>';
	}
	$echo .= '<td>';
	if(isset($_GET['Aid'])){
		$echo .= '<a href="function/edit-a.php?id='.$p_lists['id'].'&return=addP&Aid='.$_GET['Aid'].'" title="选择"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>';
	}else{
		$echo .= '<a href="edit.php?id='.$p_lists['id'].'&return=plist" title="编辑"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> ';
		$echo .= '<a href="deletedb.php?delid='.$p_lists['id'].'&return=plist" title="删除"><code><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></code></a>';
	}
	$echo .= '</td></tr>';
}

include('header.php');
include('nav.php');
?>
<div class="container p-list">
	<div class="lingheight3em"><?php include('list-nav.php');?></div><hr>
	<div class="table-responsive">
	<table class="table table-striped table-hover list-table">
		<caption><h4><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> 段落</h4></caption>
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
					echo '<th class="col-sm-5 p-contect text-center">内容</th>';
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
	<div class="col-sm-6">
	<nav aria-label="Page navigation">
		<ul class="pagination">
			<?php
			// Previous前一页
			if( $cur_page > 1){
				$page_link .= '<li><a href="'.changeURLGet('page',$cur_page - 1).'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}else{
				$page_link .= '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}
			// 循环页数
			for ($i=1; $i <= $num_page; $i++) { 
				if ($cur_page == $i) {
					$page_link .= '<li class="active"><a href="'.changeURLGet('page',$cur_page).'">'.$cur_page.'</a></li>';
				}else{
					$page_link .= '<li><a href="'.changeURLGet('page',$i).'">'.$i.'</a></li>';
				}
			}
			// Next下一页
			if ($cur_page < $num_page-1){
				$page_link .= '<li><a href="'.changeURLGet('page',$cur_page + 1).'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}else{
				$page_link .= '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}
			echo $page_link;
			?>
			
		</ul>
	</nav>
	</div>
	<div class="col-sm-6">
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
			<span class="hidden-sm hidden-xs">显示条数:</span>
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
			<span class="hidden-sm hidden-xs">状态：</span>
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
			<span class="hidden-sm hidden-xs">类别：</span>
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