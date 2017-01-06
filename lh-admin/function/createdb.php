<?php
echo '<p>开始创建数据库</p>';

function setup_connetDB(){
	global $dataBase;
	$conn = mysql_connect($dataBase['dbhost'], $dataBase['dbuser'], $dataBase['dbpass']);
	if(!$conn){
        echo '<p class="text-danger">无法链接数据库,请检查填写是否正确</p>'.mysql_error();
    }else{
    	echo '<p>链接数据库正常.....</p>';
    }
}

function setup_createUserTable(){
	global $dataBase;
	$conn = mysql_connect($dataBase['dbhost'], $dataBase['dbuser'], $dataBase['dbpass']);
	mysql_select_db($dataBase['dbname'], $conn);
	$tableName = $dataBase['dbprefix'].'user';
	$sql = 'CREATE TABLE '.$tableName.'(
			FirstName varchar(15),
			LastName varchar(15),
			Age int)';
	mysql_query($sql,$conn);
	echo '<p>创建'.$tableName.'表，正常.....</p>';
	echo $sql;
}

setup_connetDB();
setup_createUserTable();

?>