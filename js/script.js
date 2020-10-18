window.onload = function() {
function init (i, i1="", i2="", i3="") { //Выводит карту на главный экран
		/**
		 * Создаем мультимаршрут.
		 * Первым аргументом передаем модель либо объект описания модели.
		 * Вторым аргументом передаем опции отображения мультимаршрута.
		 */
		var multiRoute = new ymaps.multiRouter.MultiRoute({
				// Описание опорных точек мультимаршрута.
				referencePoints: [
						i1,
						i2,
						i3
				],
				// Параметры маршрутизации.
				params: {
					avoidTrafficJams: true
				}
		}, {
				// Автоматически устанавливать границы карты так, чтобы маршрут был виден целиком.
				boundsAutoApply: true
		});
		// Создаем карту с добавленными на нее кнопками.
		var myMap = new ymaps.Map('map', {
				center: [62.022694, 129.729095],
				zoom: 12
		}, {
				buttonMaxWidth: 300
		});
		// Добавляем мультимаршрут на карту.
		myMap.geoObjects.add(multiRoute);
}

function timingCouriers(i, i1="", i2="", i3="", id, lenght) { //нужен для выборки самого ближайшего курьера
		/**
		 * Создаем мультимаршрут.
		 * Первым аргументом передаем модель либо объект описания модели.
		 * Вторым аргументом передаем опции отображения мультимаршрута.
		 */
		var multiRoute = new ymaps.multiRouter.MultiRoute({
				// Описание опорных точек мультимаршрута.
				referencePoints: [
						i1,
						i2,
						i3
				],
				// Параметры маршрутизации.
				params: {
					avoidTrafficJams: true
				}
		}, {
				// Автоматически устанавливать границы карты так, чтобы маршрут был виден целиком.
				boundsAutoApply: true
		});
		multiRoute.model.events.add('requestsuccess', function() {
	    // Получение ссылки на активный маршрут.
	    var activeRoute = multiRoute.getActiveRoute();
	    // Вывод информации о маршруте.
			var activeRoutePaths = activeRoute.getPaths();    
			// Проход по коллекции путей.
			var arrCouriersTemp = [];
			arrCouriersTemp.push(id);
			arrCouriersTemp.push(activeRoute.properties.get("distance").value);
			arrCouriersTemp.push(activeRoute.properties.get("distance").text);
			arrCouriersTemp.push(activeRoute.properties.get("durationInTraffic").text);
			activeRoutePaths.each(function(path) {
					arrCouriersTemp.push(path.properties.get("distance").text);
					arrCouriersTemp.push(path.properties.get("durationInTraffic").text);
			    // console.log("Длина пути: " + path.properties.get("distance").text);
			    // console.log("Время прохождения пути: " + path.properties.get("durationInTraffic").text);
			});
			arrCouriers.push(arrCouriersTemp);
			if (arrCouriers.length == lenght) {
				arrCouriers.sort(function(a, b) {
				  return a[1] - b[1];
				});
				//console.log(arrCouriers);
				if(document.querySelector(".select_option_couriers")){
					document.querySelectorAll(".select_option_couriers").forEach((element) => {
						element.remove();
					});
				}
				for (var j=0; j<=arrCouriers.length-1; j++) {
					// document.querySelector(".select_couriers").append("<option data-lat="+allCouriers[arrCouriers[j][0]].lat+" data-lng="+allCouriers[arrCouriers[j][0]].lng+">"+allCouriers[arrCouriers[j][0]].name+"</option>");
					document.querySelector(".select_couriers").insertAdjacentHTML('beforeend', "<option class='select_option_couriers' value="+allCouriers[arrCouriers[j][0]].name+" data-id="+allCouriers[arrCouriers[j][0]].id+" data-lat="+allCouriers[arrCouriers[j][0]].lat+" data-lng="+allCouriers[arrCouriers[j][0]].lng+">"+allCouriers[arrCouriers[j][0]].name+" ("+arrCouriers[j][2]+"/"+arrCouriers[j][4]+") "+arrCouriers[j][3]+"/"+arrCouriers[j][5]+" | "+allCouriers[arrCouriers[j][0]].transport+"</option>");
				}
			}
		});
}
var arrCouriers = []; //массив с маршрутом всех курьеров, отсортированный по наименьшему пути
var allCouriers = []; //массив со всеми свободными курьерами из бд
ymaps.ready(init); //запускает отрисовку карты на главной страницы после загрузки скрипта яндекс


function axi(storage='', final='') {
	$.ajax({
		url: '../php/response.php',
		cache: false,
		type: 'POST',
		data: {'do': 'selectAllcouriers'},
		dataType: 'json',
		success: function(response) {
			if (IsJsonString(response)) {
				var response = jQuery.parseJSON(response);
			}

			allCouriers = response
			//console.log(allCouriers);
			arrCouriers = [];
			for (var i=0; i<=response.length-1; i++) {
				//console.log('['+response[i].lat+', '+response[i].lng+']' + " | " + storage + " | " + final);
				timingCouriers('', [response[i].lat, response[i].lng], storage, final, i, response.length);
			}

		},
		error: function(xhr, status, error) {
			//console.log(xhr.responseText + '|\n' + status + '|\n' +error);
		},
	});
}

document.querySelector(".select_from_where").addEventListener('change', function (e) { //срабатывает когда выбирается элемент списка "откуда"
  let courier = document.querySelector(".select_couriers");
  let courier_lat = courier.options[courier.selectedIndex].getAttribute('data-lat');
  let courier_lng = courier.options[courier.selectedIndex].getAttribute('data-lng');
  let final = document.querySelector(".input_adress").value;
  axi(e.target.value, final); //запускает функцию которая просчитывает пути для всех курьеров
  if (e.target.value != "Выберите склад" && courier.value != "Выберите курьера") {
  	document.querySelector("#map").innerHTML = '';
		init('', [courier_lat, courier_lng], e.target.value, final);
  }
});
document.querySelector(".select_couriers").addEventListener('change', function (e) { //срабатывает когда выбирается элемент списка "выберите курьера"
  let courier = document.querySelector(".select_couriers");
  let courier_lat = courier.options[courier.selectedIndex].getAttribute('data-lat');
  let courier_lng = courier.options[courier.selectedIndex].getAttribute('data-lng');
  let storage = document.querySelector(".select_from_where").value;
  let final = document.querySelector(".input_adress").value;
  if (courier.value != "Выберите курьера" && storage != "Выберите склад") {
	  document.querySelector("#map").innerHTML = '';
		init('', [courier_lat, courier_lng], storage, final);
  }
});
document.querySelector(".input_adress").addEventListener('blur', function (e) { //срабатывает когда пропадает фокус с поля конечного адреса
  let courier = document.querySelector(".select_couriers");
  let courier_lat = courier.options[courier.selectedIndex].getAttribute('data-lat');
  let courier_lng = courier.options[courier.selectedIndex].getAttribute('data-lng');
  let storage = document.querySelector(".select_from_where").value;
  let final = document.querySelector(".input_adress").value;
  axi(storage, final); //запускает функцию которая просчитывает пути для всех курьеров
  if (courier.value != "Выберите курьера" && storage != "Выберите склад") {
	  document.querySelector("#map").innerHTML = '';
		init('', [courier_lat, courier_lng], storage, final);
  }
});


/*

Дальше идет код для тестовой страницы которая показывает работу карт

*/


document.querySelector(".add_order").addEventListener('click', function (e) { // кнопка добавление товара
	let courier = document.querySelector(".select_couriers");

	let adress1 = document.querySelector(".select_from_where").value;
	let adress2 = document.querySelector(".input_adress").value;
	let courier_name = courier.options[courier.selectedIndex].getAttribute('value');
	let courier_id = courier.options[courier.selectedIndex].getAttribute('data-id');
		$.ajax({
			url: '../php/response.php',
			cache: false,
			type: 'POST',
			data: {'adress1': adress1, 'adress2':adress2, 'courier_name':courier_name, 'courier_id':courier_id, 'do':'insertOrderData'},
			dataType: 'json',
			success: function(data) {
				if (IsJsonString(data)) {
					var data = jQuery.parseJSON(data);
				}

				alert(data);

			},
			error: function(xhr, status, error) {
				// console.log(xhr.responseText + '|\n' + status + '|\n' +error);
			},
		});
});


function IsJsonString(str) { //проверяет, является строка данными json или нет
  try {
      JSON.parse(str);
  } catch (e) {
      return false;
  }
  return true;
}


};