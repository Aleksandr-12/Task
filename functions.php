<?php
	function redirect($http = ''){
		if($http){
			$redirect = $http;
		}else{
			$redirect = $_SERVER['HTTP_REFERER'];
		}
		header("Location: $redirect");
		exit;
	}
	
	function requestUrl($url){
		$params = explode('&', $url, 2);
		return $params[0];
	}
	function setFlash($name,$text, $params=""){
		$_SESSION[$name] = $text;
		
	}
	function getFlash($name){
		return $_SESSION[$name];
	}
	function delFlash($name){
		unset($_SESSION[$name]);
	}

	function h($str){
		echo htmlspecialchars($str, ENT_QUOTES);
	}
?>