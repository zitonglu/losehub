<?php
echo '<p>开始创建数据库表</p>';

function setup_createTable(){
	global $dataBase,$adminInf;
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
			user_login varchar(40) NOT NULL,
			user_pass varchar(30) NOT NULL,
			user_name varchar(30) NOT NULL DEFAULT "",
			user_email tinytext NOT NULL DEFAULT "",
			user_tel varchar(11) NOT NULL DEFAULT "")';
	if(mysql_query($sql,$conn)){
		echo '<p>创建'.$tableName.'表，正常......</p>';
	}else{
		echo '<p class="text-danger">'.mysql_error().'</p>';
	}

	$sql = 'INSERT INTO '.$tableName.'(user_login,user_pass,user_email) VALUES('.$adminInf["admin"].','.$adminInf["password"].','.$adminInf["email"].')';
	if(mysql_query($sql,$conn)){
		echo '<p>管理员信息创建成功......</p>';
	}else{
		echo '<p class="text-danger">'.mysql_error().'</p>';
	};
	echo $sql;

	mysql_close($conn);
}

setup_createTable();

?>