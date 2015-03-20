<?php
/**
 * This file contains the class that connect to an Mysql Server
 * @author victor Suarez Garcia
 *
 */

include_once 'conf/db.conf.php';
include_once 'core/common/Ranking.php';

//use PDO;
/**
 * Class Mysql: this class provides
 * @author victor suarez garcia
 *
 */
class MySQL {
	/**
	 * DB Conection
	 * @var MysqlIConnection
	 * 
	 */
	private $_connection;
	
	/**
	 * Constructor of the class
	 * @param String $_host host address
	 * @param String $_user user
	 * @param String $_password password
	 * @param String $_db database
	 * @param string $_persistent if true the connection is persistent
	 * @param number $_port port.
	 */
	public function __construct($_host, $_user, $_password, $_db, $_persistent=false, $_port=3306) {
		//Datos de conexion a bd
		$dsn = 'mysql:host=' . $_host . ';port=' . $_port . ';dbname=' . $_db;
		//Parametros de la conexion
		$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_EMULATE_PREPARES => true);
		if ($_persistent)
			$options[PDO::ATTR_PERSISTENT] = true;

		//Intentar establecer la conexion a la bd
		try {
			$this->_connection = new PDO($dsn, $_user, $_password, $options);
		} catch (PDOException $e) {
			trigger_error("Error; connecting to Database");
		}
	}
	/**
	 * Inicializa una transaccion
	 */
	public function initTransition(){
		$this->_connection->beginTransaction();
		
	}
	/**
	 * Finaliza la tranaccion en función del parametro pasado.
	 * @param bool $result si es verdadero, se realiza un commit y se guardan los cambios; si en otro caso es falso, se realiza un roolBack.
	 */
	public function EndTransitionWithRes($result){
		if($result)
			$this->_connection->commit();
		else
			$this->_connection->rollBack();
	}

	/**
	 * Realiza una consulta al servidor
	 * @param String $sql sql Consulta SQL
	 * @param Array $params Parametros de la consulta
	 * @param String $class Si este parametro esta activo, especifica la clase en la que se deben devolver los datos
	 * @return result or false if error
	 */
	public function consultar($sql, $params=null,$class=null) {

		$sth = $this->_connection->prepare($sql);
		if(!$sth){
			$errorinfo = $sth->errorInfo();
			$msg = "Error: ".$errorinfo[0]."; ".$errorinfo[2];
			throw new Exception($msg,$errorinfo[0]);
		}
		$sth->execute($params);
		if($class)
		return $sth->fetchAll(PDO::FETCH_CLASS,$class);
		else
		return $sth->fetchAll();
	}
	/**
	 * Realiza una insercion, actualizacion o eliminacion
	 * @param unknown $sql Consulta SQL
	 * @param Array $params Parametros de la consulta
	 * @return Numero de filas afectadas.
	 */
	public function ejecutar($sql, $params=null) {

		
			$sth = $this->_connection->prepare($sql);
		//	$this->logger->debug($sth);
			$res=$sth->execute($params);
			
			if(!$res){
				$errorinfo = $sth->errorinfo();

				$msg = "Error: ".$errorinfo[0]."; ".$errorinfo[2];
				throw new \Exception($msg,$errorinfo[0]);
			}
			$nrows=$sth->rowCount();
		
		return ($res)?$nrows:0;
	}
	/**
	 * Execute a Insertion DML query(insert) and returns the ID returned.
	 * @param String $sql Sql insert DML Query
	 * @param string[] $params Query Params.
	 * @throws \Exception Throws An exception if An error Ocurred.
	 * @return Integer returns the inserted ID or 0 if an error ocurred.
	 */
	public function executeWithIdResult($sql,$params=null){

		
		$sth = $this->_connection->prepare($sql);
		//$this->logger->debug($sth);
		
		$res=$sth->execute($params);
		if(!$res){
			
			$errorinfo = $sth->errorinfo();
			$msg = "Error: ".$errorinfo[0]."; ".$errorinfo[2];
			throw new \Exception($msg,$errorinfo[0]);
		}
		$lastId=$this->_connection->lastInsertId();

		return ($res)?$lastId:0;
	}
	/**
	 * Creates a new Mysql Connection from a ini file
	 * @param unknown $path path to the ini file
	 * @return \dbHelper\MySQL Mysql Connection
	 */
	public static function getConnection() {
		$dbconf = new \dbconf();
		//$dbconf->__construct();
		$db=\dbconf::getdb();
		//var_dump($dbconf);
		$port=(array_key_exists('port', $db))? $db['port']:3306;
		$mysql = new MySQL($db['host'],
				$db['user'],
				$db['password'],
				$db['db'],
				true,
				 $port);

		return $mysql;
	}
}