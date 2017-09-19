<?php


use \Softmake\PageAdmin;
use \Softmake\Page;
use \Softmake\Model\User;
use \Softmake\Model\Category;

$app->get("/administrador/categories", function(){

	User::verifyLogin();

	$categories = Category::listAll();

	$page = new PageAdmin();

	$page->setTpl("categories", [
		'categories'=>$categories
	]);

});

$app->get("/administrador/categories/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("categories-create");

});

$app->post("/administrador/categories/create", function(){

	User::verifyLogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header("Location: /administrador/categories");
	exit;

});

$app->get("/administrador/categories/:idcategory/delete", function($idcategory){

	User::verifyLogin();

	$category = new Category();

	$category->get((int) $idcategory);

	$category->delete();

	header("Location: /administrador/categories");
	exit;
});

$app->get("/administrador/categories/:idcategory", function($idcategory){

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl("categories-update", [
		'category'=>$category->getValues()
	]);
	
});

$app->post("/administrador/categories/:idcategory", function($idcategory){

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header("Location: /administrador/categories");
	exit;
	
});

$app->get("/categories/:idcategory", function($idcategory){

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new Page();
	
	$page->setTpl("category", [
		'category'=>$category->getValues(),
		'products'=>[]
	]);

});


?>