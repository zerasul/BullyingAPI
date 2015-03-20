<?php
require 'vendor/autoload.php';
require 'core/db/dbHelper.php';
$app = new \Slim\Slim();
$app->get('/hola',function(){
	
	$dbHelper = new dbHelper();
	$result=$dbHelper->getRanking();
	echo json_encode($result);
});

$app->post('/hola',function() use($app){
	$dbHelper = new dbHelper();
	$idusuario= $app->request->post('idusuario');
	$result=$dbHelper->insertVote($idusuario);
	if($result>0){
		echo json_encode($dbHelper->getVotosUsuario($idusuario));
	}else{
		echo 'Error';
	}
});
$app->run();