<?php
/**
 * LoseHub CMS 后台界面-参数设置-标签列表界面
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
$button = '';
$num_page = '1';

/**
 * 获取翻页相关信息
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;)，$lh
 * @version 2019-4-18
 * 
 * @return $cur_page等变量
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

/**
 * 按钮输出
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-4-18
 * 
 * @return $button
 */
$query = 'SELECT `tag_name`,count(*) FROM '.LH_DB_PREFIX.'tags'.' GROUP BY `tag_name`';
//echo $query;
$result = $dbn->query($query);
$tags = $result->fetchAll();
foreach ($tags as $tag) {
	$button.= '<a class="btn btn-default" href="'.changeURLGet('tagName',$tag['tag_name']).'" role="button" title="'.$tag['tag_name'].'">'.$tag['tag_name'].' ('.$tag['count(*)'].')</a>';
}

/**
 * 列表输出
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-5-4
 * 
 * @return $echo
 */
if (isset($_GET['tagName'])) {
	$query = 'SELECT A.a_id,A.a_title FROM '.LH_DB_PREFIX.'articles'.' AS A RIGHT JOIN ';
	$query .= LH_DB_PREFIX.'tags'.' AS T ON ( A.a_id = T.tag_a_id ) ';
	$query .='WHERE T.tag_name = \''.$_GET['tagName'].'\'';

	$count_query = preg_replace('/A.a_id,A.a_title/','count(*)',$query);//用于查询总行数
	$count = $dbn->query($count_query);
	$counts = $count->fetch();
	$total = $counts[0];// 获取总行数
	$num_page = ceil($total/$results_per_page);// 分页数
	//echo $count_query;分页面相关参数END

	$query .= ' LIMIT ';
	if($cur_page > 1){
		$i = (int)$results_per_page*($cur_page-1);
		$query .= $i.',';
	}
	$query .= $results_per_page;
	//echo $query;
	$result = $dbn->query($query);
	$list = $result->fetchAll();
	foreach ($list as $article) {
		$echo .= '<tr>';
		$echo .= '<th class="col-sm-1">'.$article['a_id'].'</th>';
		$echo .= '<td>'.$article['a_title'].'</td>';
		$echo .= '<td></td>';
		$echo .= '</tr>';
	}
}


include('header.php');
include('nav.php');
?>
<div class="container p-list tag-list">
	<div class="lingheight3em"><?php include('option-nav.php');?></div><hr>
	<div class="row table-responsive">
	<table class="table table-striped table-hover list-table text-center">
		<caption>
			<h4><span class="glyphicon glyphicon-hdd" aria-hidden="true"></span> 标签项</h4>
			<p class="text-2em">长篇文章的标签选项</p>
		</caption>
		<thead>
			<tr>
				<th class="col-sm-1">#</th>
				<th class="text-center col-sm-7">标题</th>
				<th class="text-center col-sm-4">标签</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $echo;?>
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
	<div class="col-sm-12 col-xs-12 tagbox">
		<?php echo $button;?>
	</div>
</div>
<?php include('footer.php');?>