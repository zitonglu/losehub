<?php
/**
 * LoseHub CMS 后台界面-文章发布及编辑界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;),$lh
 * @version 2019-4-16
 * 
 * @return none
 */
require_once('function/base.php');
require_once('function/authorize.php');

$type = 'A';
$state = 'P';
$title = null;
$checkbox = null;

if (isset($_GET['Aid']) === TRUE) {
	$Aid_value = ' value="'. $_GET['Aid'].'"';
	$query = "SELECT MAX(p_order) FROM ".LH_DB_PREFIX.'paragraphs';
	$query .= " WHERE `p_a_id`=".$_GET['Aid'];
	$result = $dbn->query($query);
	while ($row = $result->fetch(PDO::FETCH_ASSOC)){
		$p_order = $row['MAX(p_order)'];
		$p_order += 1;
	}
}else{
	$p_order ='10';
	$Aid_value = null;
}

include('header.php');
include('nav.php');
?>
<div class="container edit edit-article">
	<div class="container"><div class="row" id="editbox">
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
			<p class="text-right">
				<a class="btn btn-default" id="Btn1" title="加大字体" type="submit"><span class="glyphicon glyphicon-text-size" aria-hidden="true"></span>+</a>
				<a class="btn btn-default" id="Btn2" title="缩小字体" type="submit"><span class="glyphicon glyphicon-text-size" aria-hidden="true"></span>-</a>
			</p><!-- 变更字体大小 -->
		</div>
		<div class="col-sm-1 col-xs-1">
			<a href="<?php echo changeURLGet('return','Aedit');?>" title="编辑"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a><br>
		</div><!-- 只读文章页面 -->
		<div class="clearfix"></div>
	<?php }//编辑首部标题部分
		$query = "SELECT * FROM ".LH_DB_PREFIX.'paragraphs';
		$query .= " WHERE `P_a_id`=".$_GET['Aid'];
		$query .= " ORDER BY `p_order` ASC";
		// echo $query;
		$result = $dbn->prepare($query);
		$result->execute();
		$p_list = $result->fetchAll();
		//根据AID查询所有对应的段落，结束
		foreach ($p_list as $p) { ?>
			<?php if (@$_GET['return'] == 'Pedit' && @$_GET['Pid'] == $p['id']) {
				$query = 'SELECT * FROM '.LH_DB_PREFIX.'paragraphs'.' WHERE `id`='.$_GET['Pid'];
				//echo $query;
				$result = $dbn->prepare($query);
				$result->execute();
				while ($lh_paragraphs = $result->fetch(PDO::FETCH_ASSOC)){
					$textarea = $lh_paragraphs['p_contect'];
					$type_C = $lh_paragraphs['p_type_code'];
					$state_C = $lh_paragraphs['p_state_code'];
					$p_order = $lh_paragraphs['p_order'];
					if ($lh_paragraphs['p_c_state_code'] == 'P') {
						$checkbox = 'checked';
					}else{
						$checkbox = null;
					}
				}
			//输出段落编辑页面 ?>
		<hr id="editP">
		<form action="function/edit-p.php" method="post" enctype="multipart/form-data">
			<div class="col-sm-1 hidden-xs text-right">#</div>
			<div class="col-lg-8 col-sm-7">
				<textarea name="textarea" required id="summernote2"><?php echo ltrim($textarea);?></textarea>
			</div>
			<div class="col-lg-3 col-sm-4">
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
					<div class="input-group" id="p-order">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" disabled="disabled"><span class="glyphicon glyphicon-sort-by-order"></span> 段落序号</button>
						</span>
						<input type="number" class="form-control" value="<?php echo $p_order;?>" name="p_order">	
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" id="plus"><span class="glyphicon glyphicon-plus"></span></button>
							<button class="btn btn-default" type="button" id="minus"><span class="glyphicon glyphicon-minus"></span></button>
						</span>
					</div>
					<label class="checkbox-inline">
						<input type="checkbox" name="comments" <?php echo $checkbox;?>><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 可评论
					</label>
					<div class="lingheight3em text-right">
						<input type="hidden" name="id" value="<?php echo $p['id'];?>">
						<input type="hidden" name="Aid" value="<?php echo $_GET['Aid'];?>">
						<input type="hidden" name="return" value="<?php echo $_GET['return'];?>">
						<button type="submit" class="btn btn-default" name="remove"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> 断开</button>
						<a class="btn btn-default" href="<?php echo changeURLGet('return','view') ?>" role="button"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> 返回</a>
						<button type="submit" class="btn btn-default" name="send"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 完成</button>
					</div>
				</div><!-- end panel-group -->
			</div>
			<div class="clearfix"></div>
		</form>
		<hr>
			<?php }else{
			//输出正常页面
			$Purl = changeURLGet('Pid',$p['id'],true).'&return=Pedit&Aid='.$_GET['Aid'].'#editP';
			?>
		
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
			<a href="p-list.php?return=addP&Aid=<?php echo $_GET['Aid'];?>" class="btn btn-default"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> 选取段落</a>
			<button type="submit" class="btn btn-default" data-toggle="collapse" href="#collapseTWO" aria-expanded="false" aria-controls="collapseListGroup1"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> 增加段落</button>

			<div id="collapseTWO" class="collapse top-1em"><!-- 直接增加段落 -->
				<form action="function/edit-p.php" method="post" enctype="multipart/form-data">
					<textarea name="textarea" required id="summernote"></textarea>
						<div class="col-sm-7">
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
						<div class="input-group col-sm-5" id="p-order">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" disabled="disabled"><span class="glyphicon glyphicon-sort-by-order"></span> 段落序号</button>
							</span>
							<input type="number" class="form-control" value="<?php echo $p_order;?>" name="p_order">	
							<span class="input-group-btn">
								<input type="hidden" name="Aid" value="<?php echo $_GET['Aid'];?>">
								<input type="hidden" name="return" value="article">
								<input type="hidden" name="p_order" value="<?php echo $p_order;?>">
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
		<div class="col-lg-8 col-sm-7">
			<textarea name="title" required class="form-control" rows="3" placeholder="文章标题"><?php echo $title;?></textarea>
		</div>
		<div class="col-lg-3 col-sm-4">
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
				<div class="lingheight3em">
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
<hr>
<?php include('footer.php');?>