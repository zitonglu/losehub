<?php
/**
 * LoseHub CMS 后台界面-文章发布及编辑界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;),$lh
 * @version 2019-4-9
 * 
 * @return none
 */
require_once('function/base.php');
require_once('function/authorize.php');

$type = 'A';
$state = 'P';
$title = null;
$checkbox = null;
$p_order ='10';//这个东西后期做加强判断
if (isset($_GET['Aid']) === TRUE) {
	$Aid_value = ' value="'. $_GET['Aid'].'"';
}else{
	$Aid_value = null;
}

include('header.php');
include('nav.php');
?>
<div class="container edit edit-article">
	<div class="container"><div class="row">
	<?php if(is_numeric(@$_GET['Aid'])){ 
		$query = "SELECT * FROM ".LH_DB_PREFIX.'articles';
		$query .= " WHERE `a_id`=".$_GET['Aid'];
		// echo $query;
		$result = $dbn->prepare($query);
		$result->execute();
	while ($lh_articles = $result->fetch(PDO::FETCH_ASSOC)){
		$id = $lh_articles['a_id'];
		$title = $lh_articles['a_title'];
		$type_c = $lh_articles['a_type_code'];
		$state_C = $lh_articles['a_state_code'];
		if ($lh_articles['a_c_state_code'] == 'P') {
			$checkbox = 'checked';
		}else{
			$checkbox = null;
		}//根据AID查询对应文章，结束
	}?>
	<?php if (@$_GET['return'] == 'Aedit'){//如果是直接跳转，就用只读模式 ?>
		<form action="function/edit-a.php" method="post" enctype="multipart/form-data">
			<div class="col-sm-1 hidden-xs text-right hidden-xs"><h4><?php echo $id; ?></h4></div>
			<div class="col-sm-8">
				<textarea name="title" required class="form-control" rows="3"><?php echo $title;?></textarea>
			</div>
			<div class="col-sm-3">
				<div class="option">
					<select class="form-control selectbox" name="type" required>
						<?php foreach ($types as $key => $value) {
							if ($key == $type_C) {
								$checked = ' selected = "selected"';
							}else{
								$checked ='';
							}
							echo '<option value="'.$key.'"'.$checked.'>'.$value.'</option>';
						}
						?>
					</select> <select class="form-control selectbox" name="state" required>
						<?php foreach ($states as $key => $value) {
							if ($key == $state_C) {
								$checked = ' selected = "selected"';
							}else{
								$checked ='';
							}
							echo '<option value="'.$key.'"'.$checked.'>'.$value.'</option>';
						}
						?>
					</select>
				</div>
				<div class="panel-group">
					<div>
						<input type="hidden" name="Aid"<?php echo $Aid_value;?>>
						<button type="submit" class="btn btn-default" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseListGroup1"> <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> 参数</button>
						<button type="submit" class="btn btn-success" name="edit"> <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</button>
					</div>
					<div id="collapseThree" class="collapse text-right">
						<label class="checkbox-inline">
							<input type="checkbox" name="comments" <?php echo $checkbox;?>><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 可评论
						</label>
					</div>
				</div>
			</div>
		</form><!-- 编辑文章页面 -->
	<?php }else{ ?>
		<div class="col-sm-1 text-right hidden-xs"><h4>#</h4></div>
		<div class="col-sm-10 col-xs-11 text-center">
			<h2><?php echo $title; ?></h2>
		</div>
		<div class="col-sm-1 col-xs-1">
			<a href="<?php echo changeURLGet('return','Aedit');?>" title="编辑"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
		</div><!-- 只读文章页面 -->
	<?php }//编辑首部标题部分
		$query = "SELECT * FROM ".LH_DB_PREFIX.'paragraphs';
		$query .= " WHERE `P_a_id`=".$_GET['Aid'];
		$query .= " ORDER BY `p_order` ASC";
		// echo $query;
		$result = $dbn->prepare($query);
		$result->execute();
		$p_list = $result->fetchAll();
		//根据AID查询所有对应的段落，结束
		foreach ($p_list as $p) { 
			if (@$_GET['return'] == 'Pedit') {
				# 输出编辑页面
				echo "编辑页面";
			}else{
				$Purl = changeURLGet('Pid',$p['id'],true).'&return=Pedit&Aid='.$_GET['Aid'];
			?>
		<div class="clearfix"></div>
		<div class="col-sm-1 text-right hidden-xs"><small><a href="<?php echo $Purl ?>" title="编辑"><kbd><?php echo $p['p_order']; ?></kbd></a></small></div>
		<div class="col-sm-10 col-xs-11">
			<?php if(substr($p['p_contect'],0,1) == '<'){
				echo $p['p_contect'];
			}else{
				echo '<p>'.$p['p_contect'].'</p>';
			}?>
		</div>
		<div class="col-sm-1 col-xs-1">
			<a href="<?php echo $Purl ?>" title="编辑"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
		</div><!-- 只读段落页面 -->
		<div class="clearfix"></div>
		<?php }
		} ?>
	 	<div class="clearfix"></div>
		<hr>
		<div class="col-sm-11 col-md-offset-1 col-xs-12">
			<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> 选取段落</button>
			<button type="submit" class="btn btn-default" data-toggle="collapse" href="#collapseTWO" aria-expanded="false" aria-controls="collapseListGroup1"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> 增加段落</button>
			<div id="collapseTWO" class="collapse top-1em"><!-- 直接增加段落 -->
				<form action="function/edit-p.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="Aid"<?php echo $Aid_value;?>>
					<input type="hidden" name="return" value="article">
					<input type="hidden" name="p_order" value="<?php echo $p_order;?>">
					<textarea name="textarea" required id="summernote"></textarea>
						<div class="input-group" id="p-order">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" disabled="disabled"><span class="glyphicon glyphicon-sort-by-order"></span> 段落序号</button>
							</span>
							<input type="number" class="form-control" value="<?php echo $p_order;?>" name="p_order">	
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" id="plus"><span class="glyphicon glyphicon-plus"></span></button>
								<button class="btn btn-default" type="button" id="minus"><span class="glyphicon glyphicon-minus"></span></button>
								<button type="submit" class="btn btn-default" name="send"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 发布</button>
							</span>
						</div>
				</form>
			</div>
		</div>
	<?php }else{ //没有生产文章ID的情况?>
	<form action="function/edit-a.php" method="post" enctype="multipart/form-data">
		<div class="col-sm-1 hidden-xs text-right hidden-xs"><h4><i>#</i></h4></div>
		<div class="col-sm-8">
			<textarea name="title" required class="form-control" rows="3" placeholder="文章标题"><?php echo $title;?></textarea>
		</div>
		<div class="col-sm-3">
			<div class="option">
				<select class="form-control selectbox" name="type" required>
					<?php foreach ($types as $key => $value) {
						if ($key == $type_C) {
							$checked = ' selected = "selected"';
						}else{
							$checked ='';
						}
						echo '<option value="'.$key.'"'.$checked.'>'.$value.'</option>';
					}
					?>
				</select> <select class="form-control selectbox" name="state" required>
					<?php foreach ($states as $key => $value) {
						if ($key == $state_C) {
							$checked = ' selected = "selected"';
						}else{
							$checked ='';
						}
						echo '<option value="'.$key.'"'.$checked.'>'.$value.'</option>';
					}
					?>
				</select>
			</div>
			<div class="panel-group">
				<div>
					<input type="hidden" name="Aid"<?php echo $Aid_value;?>>
					<a class="btn btn-default" href="edit.php" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 写短文</a>
					<button type="submit" class="btn btn-default" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseListGroup1"> <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> 参数</button>
					<button type="submit" class="btn btn-default" name="new"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span> 新建</button>
				</div>
				<div id="collapseOne" class="collapse text-right">
					<label class="checkbox-inline">
						<input type="checkbox" name="comments" <?php echo $checkbox;?>><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 可评论
					</label>
				</div>
			</div>
		</div>
	</form>
	<?php } ?>
	</div><!-- end row -->
	</div>
</div>
<?php include('footer.php');?>