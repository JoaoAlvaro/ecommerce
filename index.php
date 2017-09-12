<?php 

ini_set('session.save_path', 'tmp');
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

	header("Location: /administrador");
	exit;
}); 

$app->get('/administrador/logout', function() {
    
	User::logout();

	header("Location: /administrador/login");
	exit;
});

$app->get('/administrador/users', function() {
    
	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin(); 

	$page->setTpl("users", array(
		"users"=>$users
	));	

});

$app->get('/administrador/users/create', function() {
    
	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$user->setData($_POST);

	$user->save();

	header("Location: /administrador/users");
	exit;

	
});

$app->get('/administrador/users/:iduser/delete', function($iduser) {
    
	User::verifyLogin();

});

$app->get('/administrador/users/:iduser', function($iduser) {
    
	User::verifyLogin();

	$user->get((int)$iduser);

	$page = new PageAdmin(); 

	$page->setTpl("users-update", array(
		"user"=>$user->getValues()
	));	

});

$app->post('/administrador/users/create', function() {
    
	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$user->setData($_POST);

	$user->save();

	header("Location: /administrador/users");
	exit;

});

$app->post('/administrador/users/:iduser', function($iduser) {
    
	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$user->get((int)$iduser);

	$user->setData($_POST);

	$user->update();

	header("Location: /administrador/users");
	exit;

});


$app->run();

 ?>