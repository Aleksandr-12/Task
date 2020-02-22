<?php 
require_once 'Controller/PageController.php';
require_once 'functions.php';
	
	if($_GET){
		$data = $_GET;
	}
	$url = trim($_SERVER['QUERY_STRING'], '/');
	$pageName = requestUrl($url);
	New PageController($pageName,$data);
?>


