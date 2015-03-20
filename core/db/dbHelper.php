<?php
 require_once 'core/db/MySQL.php';
 class dbHelper{

 	private $sqlConnection;
 	public function __construct(){

 		$this->sqlConnection=MySQL::getConnection();
 	}
 	public function getRanking(){
 		$sql ="select * from votosusuarios order by votos desc";
 		$params = array();
 		$this->sqlConnection->ejecutar("SET CHARACTER SET utf8");
 		$result= $this->sqlConnection->consultar($sql,$params,'\common\Ranking');
 		if(count($result)==0)return false;
 		return $result;
 	}
 	public function insertVote($idUsuario){
 		$sql = "insert into voto(idusuario,voto)values(?,1)";
 		$params = array($idUsuario);
 		$this->sqlConnection->ejecutar("SET CHARACTER SET utf8");
 		$result = $this->sqlConnection->ejecutar($sql,$params);
 		return $result;
 	}
 	public function getVotosUsuario($idUsuario){
 		$sql = "select idusuario, votos from votosusuarios where idusuario=?";
 		$params=array($idUsuario);
 		$this->sqlConnection->ejecutar("SET CHARACTER SET utf8");
 		$result= $this->sqlConnection->consultar($sql,$params);
 		if(count($result)==0)return false;
 		return $result;

 	}
 }
?>