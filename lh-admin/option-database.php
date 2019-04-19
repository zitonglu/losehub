<?php
/**
 * LoseHub CMS 后台界面-参数设置-数据库列表界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;),$lh
 * @version 2019-4-17
 * 
 * @return none
 */
require_once('function/base.php');
require_once('function/authorize.php');

$echo = '';
/**
 * editOption修改预选项值
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;)
 * @version 2019-4-18
 * 
 * @return option-database.php
 */
if (isset($_POST['editOption'])) {
	$query = 'UPDATE '.LH_DB_PREFIX.'options'.' SET ';
	$query .= '`option_value`=\''.$_POST['optionValue'].'\'';
	$query .= ' WHERE `option_code`=\''.$_POST['optionCode'].'\'';
	//echo $query;
	$dbn->query($query);
	redirect('option-database.php');
}

/**
 * addOption增加预选项值
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;)
 * @version 2019-4-18
 * 
 * @return option-database.php
 */
if (isset($_POST['addOption'])) {
	$query = 'INSERT IGNORE INTO '.LH_DB_PREFIX.'options';
	$query .= ' (`option_code`,`option_value`) values ';
	$query .= '(\''.$_POST['optionCode'].'\',\''.$_POST['optionValue'].'\')';
	//echo $query;
	$dbn->query($query);
	redirect('option-database.php');
}

/**
 * 获取翻页相关信息
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;)，$lh
 * @version 2019-4-18
 * 
 * @return $num_page等变量
 */
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

$search_query = "SELECT * FROM ".LH_DB_PREFIX.'options';
$count_query = preg_replace('/\*/','count(*)',$search_query);//用于查询总行数

$search_query .= ' LIMIT ';
if($cur_page > 1){
	$i = (int)$results_per_page*($cur_page-1);
	$search_query .= $i.',';
}
$search_query .= $results_per_page;
$result = $dbn->prepare($search_query);
$result->execute();
$option = $result->fetchAll();

$count = $dbn->query($count_query);
$counts = $count->fetch();
$total = $counts[0];// 获取总行数
$num_page = ceil($total/$results_per_page);// 分页数
// 获取翻页相关信息 end

$explain = array(
	'site_name' => '站点名称',
	'author_email' => '作者邮箱',
	'site_url' => '网站网址',
	'wwwroot' => '网站根目录',
	'row_number' => '显示行数'
);

/**
 * 列表输出
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-4-18
 * 
 * @return $echo
 */
foreach ($option as $options) {
	$echo .= '<tr>';
	$echo .= '<th scope="row">'.$options['option_code'].'</th>';
	if (@$_GET['return'] == 'optionDatabase' && @$_GET['code'] == $options['option_code']) {
		//编辑code
		$echo .= '<td><form action="'.$_SERVER['PHP_SELF'].'" method="post">';
		$echo .= '<input type="hidden" name="optionCode" value="'.$options['option_code'].'">';
		$echo .= '<div class="input-group">';
		$echo .= '<input type="text" class="form-control" name="optionValue" value="'.$options['option_value'].'">';
      	$echo .= '<span class="input-group-btn">';
        $echo .= '<button class="btn btn-default" type="submit" name="editOption"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>';
		$echo .= '</span></div></form></td>';
	}else{
		$echo .= '<td class="p-contect"><a href="option-database.php?code='.$options['option_code'].'&return=optionDatabase"> '.$options['option_value'].'</a></td>';
	}
	if ($options['option_autoload'] == 'Y') {
		$echo .= '<td><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>';
	}else{
		$echo .= '<td><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span></td>';
	}
	if (!empty($explain[$options['option_code']])) {
		$echo .= '<td>'.$explain[$options['option_code']].'</td>';
	}else{
		$echo .= '<td></td>';
	}
	$echo .= '<td>&lt;?php echo <code>$lh[\''.$options['option_code'].'\']</code>;?&gt;</td>';
	$echo .= '<td>';
	$echo .= '<a href="option-database.php?code='.$options['option_code'].'&return=optionDatabase" title="编辑"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> ';
	if (empty($explain[$options['option_code']])) {//默认选项不可删除
		$echo .= '<a href="deletedb.php?delOption='.$options['option_code'].'&return=optionDatabase" title="删除"><code><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></code></a>';
	}
	$echo .= '</td></tr>';
}

include('header.php');
include('nav.php');
?>
<div class="container p-list">
	<div class="lingheight3em"><?php include('option-nav.php');?></div><hr>
	<div class="row table-responsive">
	<table class="table table-striped table-hover list-table text-center">
		<caption>
			<h4><span class="glyphicon glyphicon-hdd" aria-hidden="true"></span> 预配置项</h4>
			<p class="text-2em">预配置项主要设置网站常用选项，方便二次开发。部分默认数据修改请慎重。</p>
		</caption>
		<thead>
			<tr>
				<th class="col-sm-2">代码</th>
				<th class="text-center col-sm-3">值</th>
				<th class="text-center col-sm-1">自动加载</th>
				<th class="text-center col-sm-1">说明</th>
				<th class="text-center col-sm-4">使用方法</th>
				<th class="text-center col-sm-1">编辑</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $echo;?>
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
				<input type="hidden" name="code" value="<?php echo $_GET['code'];?>">
				<tr>
					<th scope="row"><input class="form-control" type="text" name="optionCode" required placeholder="option-code"></th>
					<td>
						<div class="input-group">
							<input class="form-control" type="text" name="optionValue" required placeholder="option-value">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-default" name="addOption"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
							</span>
						</div>
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td><button type="submit" class="btn btn-link" name="addOption"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span></button></td>
				</tr>
			</form>
		</tbody>
	</table>
	</div>
	<div class="col-sm-9 col-xs-8">
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
	<div class="col-sm-3 col-xs-4">
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
		</form>
	</div>
</div>
<?php include('footer.php');?>