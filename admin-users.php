<?php


use \Softmake\PageAdmin;
use \Softmake\Model\User;

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

?>