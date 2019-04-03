<?php
    $filesName = $_FILES['file']['name'];
    $filesTmpName = $_FILES['file']['tmp_name'];

    $filePath = '../../../lh-content/uploads/'.date('ymdhis').$filesName; //文件路径

    if(move_uploaded_file($filesTmpName, $filePath))
        echo $filePath;
    else {
        echo "移动文件失败";
    }
    //echo   "<img src= '".$filePath ."'>";
?>