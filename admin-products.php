<?php

use \Softmake\PageAdmin;
use \Softmake\Model\User;
use \Softmake\Model\Product;


$app->get("/administrador/products", function(){

	User::verifyLogin();

	$products = Product::listAll();

	$page = new PageAdmin();

	$page->setTpl("products", [
		"products"=>$products
	]);
});

$app->get("/administrador/products", function(){

	User::verifyLogin();

	$products = Product::listAll();

	$page = new PageAdmin();

	$page->setTpl("products", [
		"products"=>$products
	]);
});

$app->get("/administrador/products/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("products-create");
});


$app->post("/administrador/products/create", function(){

	User::verifyLogin();

	$produtcts = new Product();

	$products->setData($_POST);

	$produtcts->save();

	header("Location: /administrador/products");
	exit;


});


?>