<?php
echo '<p>开始创建数据库表</p>';

function setup_createTable(){
	global $dataBase;
	$conn = mysql_connect($dataBase['dbhost'], $dataBase['dbuser'], $dataBase['dbpass']);
	if(!$conn){
        echo '<p class="text-danger">无法链接数据库,请检查填写是否正确</p>'.mysql_error();
        return;
    }else{
    	echo '<p>链接数据库正常.....</p>';
    }

	mysql_select_db($dataBase['dbname'], $conn);
	
	$tableName = $dataBase['dbprefix'].'user';
	$sql = 'CREATE TABLE '.$tableName.'(
			ID int NOT NULL AUTO_INCREMENT primary key, 
			user_login varchar(30) NOT NULL,
			user_pass varchar(20) NOT NULL,
			user_name varchar(20) NOT NULL DEFAULT "",
			user_email varchar(30) NOT NULL DEFAULT "",
			user_tel varchar(11) NOT NULL DEFAULT "")';
	if(mysql_query($sql,$conn)){
		echo '<p>创建'.$tableName.'表，正常.....</p>';
	}else{
		echo '<p class="text-danger">'.mysql_error().'</p>';
	}
}

setup_createTable();

?>