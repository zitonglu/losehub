<?php
/**
 * LoseHub CMS 后台界面-首页
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global $lh
 * @version 2019-3-21
 * 
 * @return html
 */
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Zitonglu">
	<title>LoseHub CMS后台程序</title>
	<!-- Bootstrap core CSS -->
    <link href="<?php echo $lh['site_url'] ?>/lh-includes/style/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $lh['site_url'] ?>/lh-admin/style/style.css?v=1.0" rel="stylesheet">
    <?php
    if (strstr($_SERVER['PHP_SELF'],'article')) {
    	echo '<link href="'.$lh['site_url'].'/lh-admin/style/summernote.css" rel="stylesheet">';
    }
    ?>
</head>
<body>