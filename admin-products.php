<?php

use \Softmake\PageAdmin;
use \Softmake\Model\User;
use \Softmake\Model\Product;


$app->get("/administrador/products", function(){

	User::verifyLogin();

	$product = Product::listAll();

	$page = new PageAdmin();

	$page->setTpl("products", [
		"products"=>$product
	]);
});

/*$app->get("/administrador/products", function(){

	User::verifyLogin();

	$product = Product::listAll();

	$page = new PageAdmin();

	$page->setTpl("products", [
		"products"=>$product
	]);
});*/

$app->get("/administrador/products/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("products-create");
});


$app->post("/administrador/products/create", function(){

	User::verifyLogin();

	$product = new Product();

	$product->setData($_POST);

	$product->save();

	header("Location: /administrador/products");
	exit;

});

$app->get("/administrador/products/:idproduct/delete", function($idproduct){

	User::verifyLogin();

	$product = new Product();

	$product->get((int) $idproduct);

	$product->delete();

	header("Location: /administrador/products");
	exit;
});


$app->get("/administrador/products/:idproduct", function($idproduct){

	User::verifyLogin();

	$product = new Product();

	$product->get((int)$idproduct);

	$page = new PageAdmin();

	$page->setTpl("products-update", [
		'product'=>$product->getValues()
	]);
	
});

$app->post("/administrador/products/:idproduct", function($idproduct){

	User::verifyLogin();

	$product = new Product();

	$product->get((int)$idproduct);
	
	$product->setData($_POST);

	$product->save();

	header("Location: /administrador/products");
	exit;
	
});


?>