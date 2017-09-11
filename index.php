<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Softmake\Page;
use \Softmake\PageAdmin;
use \Softmake\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();
	
	$page->setTpl("index");
		
});

$app->get('/administrador', function() {
    
	User::verifyLogin();

	$page = new PageAdmin();
	
	$page->setTpl("index");
		
});

$app->get('/administrador/login', function() {
    
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]); 

	$page->setTpl("login");	

});

$app->post('/administrador/login', function() {
    
	User::login($_POST["deslogin"], $_POST["despassword"]);

	header("Location: /admin");
	exit;
}); 

$app->get('/administrador/logout', function() {
    
	User::logout();

	header("Location: /administrador/login");
	exit;
});



$app->run();

 ?>