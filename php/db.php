<?php 

function print_arr($arr){
	echo '<pre>' . print_r($arr, true) . '</pre>';
}

$db = mysqli_connect('127.0.0.1', 'root', '', 'mypoint');
if(!$db) die(mysqli_connect_error());
mysqli_set_charset($db, "utf8") or die ('Не установлена кодировка');

function clear(){
	global $db;
	foreach ($_GET as $key => $value) {
		$_GET[$key] = mysqli_real_escape_string($db, $value);
	}
	foreach ($_POST as $key => $value) {
		$_POST[$key] = mysqli_real_escape_string($db, $value);
	}
}

session_start();
 ?>