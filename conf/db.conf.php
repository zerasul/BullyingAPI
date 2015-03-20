<?php
class dbconf{
 private  $db;

 

 public static function getdb(){
 	$db=array();
 	$db['db']='<database>';
	$db['user']='<user>';
	$db['password']='<password>';
	$db['host']='<db_address>';
	$db['port']=3306;
 	return $db;
 }
}
?>