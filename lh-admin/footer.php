<?php
/**
 * LoseHub CMS 后台界面-footer
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global $lh
 * @version 2019-3-21
 * 
 * @return none
 */
?>

<!-- <p class="text-center">感谢使用<a href="losehub.com" target="_blank" title="losehub">LoseHub CMS</a>进行创作</p> -->
	<script src="<?php echo $lh['site_url'] ?>/lh-includes/style/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script src="<?php echo $lh['site_url'] ?>/lh-includes/style/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo $lh['site_url'] ?>/lh-admin/style/active.js" type="text/javascript"></script>
	<?php
    if (strstr($_SERVER['PHP_SELF'],'edit')) {
    	echo '<script src="'.$lh['site_url'].'/lh-admin/function/summernote/summernote.min.js" type="text/javascript"></script>';
    	echo '<script src="'.$lh['site_url'].'/lh-admin/function/summernote/summernote-zh-CN.js" type="text/javascript"></script>';
    	echo '<script src="'.$lh['site_url'].'/lh-admin/function/summernote/summernoteloadpic.js" type="text/javascript"></script>';
    	}
    ?>
</body>
</html>