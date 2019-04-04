<?php
/**
 * LoseHub CMS 后台界面-文章发布及编辑界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;),$lh
 * @version 2019-4-2
 * 
 * @return none
 */
require_once('function/base.php');
require_once('function/authorize.php');

$type_C = 'A';
$state_C = 'P';
$title_value = null;

if (isset($_GET['Aid']) === TRUE) {
	$Aid_value = $_GET['Aid'];
}else{
	$Aid_value = null;
}

include('header.php');
include('nav.php');
?>
<div class="container edit-article">
	<div class="row">
	<div class="col-sm-1 hidden-xs text-right">#</div>
		<textarea id="summernote"></textarea>
	<hr>
	</div>
</div>
<?php include('footer.php');?>