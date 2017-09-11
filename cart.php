<?php session_start();

foreach ($_SESSION['cart'] as $key => $value) {
    
    $img = explode(",",$value['product_image']);

    $sum = $value['product_price'] * $value['count'];

	$cart .= "<tr>
			<td>
			<div class='cart_img' style='background:url(http://".$_SERVER['HTTP_HOST']."/download/$img[0]);'></div>
			
			</td>

			<td>$value[product_name]</td>
			<td></td>
			<td>
			<span class='minus' data-id = '$value[product_id]'>-</span>
			<input style='width: 50px; text-align: center;' type='text' value='$value[count]' disabled>
			<span class='plus' data-id = '$value[product_id]'>+</span>
			</td>

			<td>$value[product_price].00/$sum.00</td>
			<td><button class='delete' data-id='$value[product_id]'>Удалить</button></td>

		</tr>";
}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">

<link rel="stylesheet" type="text/css" href="style.css">
<script
  src="https://code.jquery.com/jquery-3.2.0.js"
  integrity="sha256-wPFJNIFlVY49B+CuAIrDr932XSb6Jk3J1M22M3E2ylQ="
  crossorigin="anonymous">
  </script>
 <script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body>
	
	<div class="container-fluid top-menu">
		<div class="row">
			<div class="col-md-12">
				 
				  <div class="container">
				  	  <div class="row">
				  	  	<div class="col-md-12"></div>
				  	  </div>
				  </div>

			</div>
		</div>

	</div>
<div class="container">

	<div class="row">
		<div class="col-md-12">
			<table class="table table-stripped">
	<thead>
		<tr>
			<td>Фото</td>
			<td>название</td>
			<td>цвет</td>
			<td>количество</td>
			<td>цена/сумма</td>
			<td>удалить</td>

		</tr>

	</thead>
	<tbody>
		
		<?php echo $cart; ?>
	</tbody>


</table>

		</div>
		
	</div>

	<div class="row">

		<div class="col-md-3" class="col-md-9" class="form-group" style=" position: absolute; left: 35%; right: 50%;">
			<form method="POST" id="otpravka" role="form" >
			  <legend>Форма Отправки</legend>

				<label>Фамилия</label><input class="form-control" type="text"  placeholder="Введите фамилию">
				<label>Имя</label><input class="form-control" type="text" placeholder="Введите имя">
				<label>Отчество</label><input class="form-control" type="text" placeholder="Введите отчество">
				<label>Номер телефона</label><input class="form-control" type="text" placeholder="Введите номер телефона">
				<label>Адресс</label><input class="form-control" type="text" placeholder="Введите адресс">
				<label>E-mail</label><input class="form-control" type="email" placeholder="Введите email">
				<label>Способ доставки</label>
				<select class="form-control">
				<option disabled selected>Выберите способ доставки</option>
					<option>Самовывоз</option>
 					<option>Новая почта</option>
 					<option>УкрПочта</option>
				</select>
		

			</form>

		</div>

	</div>

</div>
<script type="text/javascript" src="js/main.js"></script>
</body>

</html>
