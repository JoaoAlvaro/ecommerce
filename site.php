<?php


use \Softmake\Page;

$app->get('/', function() {
    
	$page = new Page();
	
	$page->setTpl("index");
		
});


?>