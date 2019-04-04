<?php
/**
 * 富文本上传图片函数
 * @copyright summernote
 * @author 紫铜炉 910109610@QQ.com
 * @var $lh
 * @version 2019-4-3
 * 
 * @return $lh['site_url'].$filePath
 */
require_once('../base.php');

$filePath = '/lh-content/uploads/'.date('ymdhi').$_FILES['file']['name'];

if(move_uploaded_file($_FILES['file']['tmp_name'],'../../..'.$filePath)){
    echo $lh['site_url'].$filePath;
}else{
    echo "移动文件失败";
}

?>