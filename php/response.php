<?php 
error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');
require_once 'db.php';


if ( !empty($_POST) && isset($_POST['do']) && $_POST['do'] == "selectAllcouriers" ) {
	$select = "SELECT * FROM `couriers` WHERE `status`='Свободен'";
	$res_select = mysqli_fetch_all( mysqli_query($db, $select) , MYSQLI_ASSOC);
	echo (json_encode($res_select));
}

if ( !empty($_POST) && isset($_POST['do']) && $_POST['do'] == "insertOrderData" ) {

	$adress1 = $_POST['adress1'];
	$adress2 = $_POST['adress2'];
	$courier_id = $_POST['courier_id'];
	$courier_name = $_POST['courier_name'];

	$insert = "INSERT INTO orders (adress1, adress2, courier_name, couriers, status) VALUES ('$adress1', '$adress2', '$courier_name', '$courier_id', 'Новый заказ')";
	$res_insert = mysqli_query($db, $insert);

	echo(json_encode("Успешно добавлено."));
}

 ?>