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
    $page = new PageAdmin();
    $page->setTpl("users-create");
});

$app->get('/administrador/users/:iduser/delete', function($iduser) {
    
	User::verifyLogin();

	$user = new User();

	$user->get((int) $iduser);

	$user->delete();

	header("Location: /administrador/users");
	exit;

});

$app->get('/administrador/users/:iduser', function($iduser) {
    
	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$page = new PageAdmin(); 

	$page->setTpl("users-update", array(
		"user"=>$user->getValues()
	));	

});

$app->post("/administrador/users/create", function () {

   User::verifyLogin();
   $user = new User();

   $_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

   $_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [
     "cost"=>12
   ]);

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

$app->get("/administrador/forgot", function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot");

});

$app->post('administrador/forgot', function(){

	$user = User::getForgot($_POST["email"]);

	header("Location: /administrador/forgot/sent");
	exit;

});

$app->get('administrador/forgot/sent', function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-sent");

});

$app->get("/administrador/forgot/reset", function(){
	$user = User::validForgotDecrypt($_GET["code"]);
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("forgot-reset", array(
		"name"=>$user["desperson"],
		"code"=>$_GET["code"]
	));
});

$app->run();

 ?>