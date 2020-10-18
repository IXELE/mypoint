<?php 
error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');
require_once 'php/db.php';

$select = "SELECT * FROM `orders`";
$res_select = mysqli_fetch_all( mysqli_query($db, $select) , MYSQLI_ASSOC);

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
<div id="wrapper">
	<div id="form" class="wrap_f_el">
		
		<div class="form">
			<h1>Форма доставки</h1>
			<div class = "flex__around">
				<div class = "list_inp_wrap">
					<label class="left">Откуда*</label><br/>
					<select required class="form-inputs select_from_where">
						<option disabled selected>Выберите склад</option>
						<option>Якутия Ленина проспект, 1</option>
						<option>Якутия Ленина проспект, 22</option>
					</select>
				</div>	

				<div class = "list_inp_wrap">
					<label class="left">Оператор*</label>
					<input name="city" type="text" class="list_inp"/>
					<div class = "arrow"> 

					</div>
				</div>	
			</div>
			
			<div class = "flex__around"> 
				<div id = "FIO">
					<label >Фио клиента</label>
					<input class="left" type="text" name="fio">
				</div>
				<div id = "number">	
					<label >Номер клиента</label>
					<input class="right" type="phone" name="num">
				</div>
			</div>	
			
			<div id = "adress_wrap">
				<label class="">Адрес доставки*</label><br>
				<input type = "text" name = "adress" id = "main_adress" class="input_adress">
				<div class="flex__around">
					<input type="number" name="num" class = "adress_item" placeholder="Подъезд">
					<input type="number" name="num" class = "adress_item" placeholder="Этаж">
					<input type="number" name="num" class = "adress_item" placeholder="Кв/Офис">
					<input type="phone" name="num" class = "adress_item" placeholder="Домофон">
				</div>
			</div>	

			<div class = "flex__around">
				<div class = "goods_item">
					<label class=>Вид товара</label>
					<input name="city" list="cities" type = "text" class = "list_inp"/>
					<datalist id="cities">
					   <option value="Naples" />
					   <option value="London" />
					   <option value="Berlin" />
					   <option value="New York" />
					   <option value="Frattamaggiore" />
					</datalist>
					<div class = "arrow"> 

					</div>
				</div>	

				<div class = "goods_item">
					<label class=>Стоимость</label>
					<input type ="text" placeholder="0" name = "cost">
				</div>	
			</div>

			<div class = "flex__around">
				<div class = "cost_item">
					<label >Способ оплаты</label>
					<input  type="text" name="price" class = "list_inp" list="cities">
					<datalist id="cities">
						   <option value="Naples" />
						   <option value="London" />
						   <option value="Berlin" />
						   <option value="New York" />
						   <option value="Frattamaggiore" />
						</datalist>
					<div class = "arrow"> </div>	
				</div>	
				<div class = "cost_item">
					<label>Выберите Курьера</label>
					<select class="form-inputs select_couriers">
						<option disabled selected>Выберите курьера</option>
					</select>
				</div>	
			</div>	

			<div id = "comment_wrap">
				<label >Примечание</label><br>
				<textarea ></textarea>
			</div>	

			<div class = "flex__around">
				<div id="rate" class="left flex__column"><p>Тариф: 0р</p></div>
				<input class="right btn add_order" type="submit" name="submit" value="Добавить">
		</div>	
		</div>
	</div>

	<div class="spisok">
		<h1>Список заказов</h1>
		<?php foreach ($res_select as $item): ?>
			<div class="spisok_item">
				<div class="spisok_header">
					<img src="img/user.png" alt="">
					<h2>Id: <span><?= $item['couriers']; ?></span> | Курьер: <span><?= $item['courier_name']; ?></span></h2>
					<p>01.01.2001 15:00</p>
				</div>
				<div class="spisok_tag">
					<p><?= $item['status']; ?></p>
					<p></p>
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
	
	<div id="maps" class="wrap_f_el">
		<h1>Карта</h1>
		<div id="map" style="width: 450px; height: 600px" ></div>
	</div>

</div>
	
	<script src="js/vue.js"></script>
	<script src="js/jquery-3.5.1.js"></script>
	<script src="js/script.js"></script>
	
	
</body>
</html>