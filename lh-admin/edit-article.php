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
		$type = $lh_articles['a_type_code'];
		$state = $lh_articles['a_state_code'];
		if ($lh_articles['a_c_state_code'] == 'P') {
			$checkbox = 'checked';
		}else{
			$checkbox = null;
		}
	}?>
	<?php if (@$_GET['return'] == 'view'){//如果是直接跳转，就用只读模式 ?>
		<div class="col-sm-1 text-right hidden-xs"><h4>#</h4></div>
		<div class="col-sm-10 col-xs-11 text-center">
			<h2><?php echo $title; ?></h2>
		</div>
		<div class="col-sm-1 col-xs-1">
			<a href="<?php echo changeURLGet('return','edit');?>" title="编辑"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
		</div>
		<div class="clearfix"></div><!-- 清理格式 -->
	<?php }else{ ?>
		<p>1</p>
	<?php }//编辑文章的结尾部分，没有return值都可显示 ?>
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
					<p class="text-right option">
						<select class="form-control selectbox" name="type" required>
						<?php foreach ($types as $key => $value) {
							if ($key == 'P') {
								$checked = ' selected = "selected"';
							}else{
								$checked ='';
							}
							echo '<option value="'.$key.'"'.$checked.'>'.$value.'</option>';
						}
						?>
						</select> <select class="form-control selectbox" name="state" required>
							<?php foreach ($states as $key => $value) {
								if ($key == 'P') {
									$checked = ' selected = "selected"';
								}else{
									$checked ='';
								}
								echo '<option value="'.$key.'"'.$checked.'>'.$value.'</option>';
							}
							?>
						</select>
						<button type="submit" class="btn btn-default" name="send"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 发布</button>
					</p>
				</form>
			</div>
		</div>
	<?php }else{ ?>
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