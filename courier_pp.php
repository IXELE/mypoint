<?php 
error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');
require_once 'php/db.php';

$id = $_GET['id'];
$select = "SELECT * FROM `couriers` WHERE `id`=$id";
$res_select = mysqli_fetch_all( mysqli_query($db, $select) , MYSQLI_ASSOC);


$selectOrder = "SELECT * FROM `orders` WHERE `couriers`=$id";
$res_selectOrder = mysqli_fetch_all( mysqli_query($db, $selectOrder) , MYSQLI_ASSOC);

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>My Point</title>
	<link rel="shortcut icon" type="image/png" href="img/favicon-main.png">
	<link rel="stylesheet" href="css/style.css">
	<script src="https://api-maps.yandex.ru/2.1/?apikey=b45e8fdc-19c2-4b11-a8e8-a32cea25cb98&lang=ru_RU" type="text/javascript"></script>
</head>
<body>
	<header>
		<object class="logo" 
		type="image/svg+xml"
		data="img/Logo.svg">
		<img
		src="img/Logo.svg">
	</object>
	<a href="auth_page.html">Выйти</a>
</header>


	<div id = "courier_pp_wrap">
		<?php foreach ($res_select as $item): ?>
		<h1>Добро пожаловать, <?= $item['name']; ?></h1>
		
		<div class = "flex__around">
			<div id = "pers_data_wrap">
				<h2>Личные данные</h2>

				<div id = "pers_data_inner">
					<p><strong>Имя</strong> : <?= $item['name']; ?></p>
					<p><strong>Транспорт</strong> : <?= $item['transport']; ?></p>
					<p><strong>Ваш рейтинг</strong> : <?= $item['rating']; ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>	
	<div class="spisok spisok_pp">
	<h1>Список заказов</h1>
		<?php foreach ($res_selectOrder as $item): ?>
		<div class="spisok_item">
			<div class="spisok_header">
				<img src="img/user.png" alt="">
				<h2>Id: <?= $item['couriers']; ?><span></span> | Курьер: <span><?= $item['courier_name']; ?></span></h2>
				<p>01.01.2001 15:00</p>
			</div>
			<div class="spisok_tag">
				<p><?= $item['status']; ?></p>
				<a href="#" style="float: right; margin-left: 10px; background-color: green;">Принять</a>
				<a href="#" style="float: right; background-color: red;">Отклонить</a>
			</div>
			<div class="spisok_text">
				<p class="street str_1"><span id = "point_A">A</span><?= $item['adress1']; ?></p>
				<p class="street str_2"><span id = "point_B">B</span><?= $item['adress2']; ?></p>
				<p>Подъезд: <span>15</span></p>
				<p>телефон: <span>+7(000)000-00-00</span></p>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div> 
	
	<script src="js/jquery-3.5.1.js"></script>
	<script src="js/script_lk.js"></script>
	
	
</body>
</html>