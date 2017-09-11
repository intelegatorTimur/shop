<?php session_start();
try{
	$PDO = new PDO("mysql:host=localhost;dbname=base","root","");
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){

  echo  $e->getMessage();
}
if(isset($_SESSION['cart']) AND count($_SESSION['cart']) > 0){
	foreach ($_SESSION['cart'] as $key => $value) {

		$sum += $value['count'];
	}
}else{
	$sum = 0;
}
//unset($_SESSION['cart']);


$query = $PDO->query("SELECT * FROM product LIMIT 0,6");
while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
 
  if(!empty($result['product_id'])){


		$exp_img = explode(',', $result['product_image']);
	    
	    if(!empty($exp_img[0]) && file_exists("download/".$exp_img[0])){
	       $img = $exp_img[0];
	    } else {
	    	$img = "no-image.png";
	    }

	    

		$product .="

			<div class='product-box'>

					
					<div>
					  <a href='http://".$_SERVER['HTTP_HOST']."/fullproduct.php?id=$result[product_id]'> <img src='download/$img'></a>
					</div>
					<div><h3>$result[product_name]</h3></div>
					<div>
						<h3>$result[product_price].00грн</h3>

						<button data-id = '$result[product_id]' class = 'to-cart'>В корзину</button>
					</div>
				<span class='selected_color'>
                     <fieldset>
                        <legend>укажите цвет</legend>
                     </fieldset>
				</span>
				</div>
		";
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="style.css">
<script
  src="https://code.jquery.com/jquery-3.2.0.js"
  integrity="sha256-wPFJNIFlVY49B+CuAIrDr932XSb6Jk3J1M22M3E2ylQ="
  crossorigin="anonymous">
  </script>
 <script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body>
	<div id="cart_count">
		<center><a href="http://first.loc/cart.php"><img src="images/cart.png"></a></center>
		<span><?php echo $sum ?></span>
	</div>
	<div id="alert" class="c">
		<center><img src="images/cart.png"></center>
		<center><h2>Товар добавлен в корзину</h2></center>
	</div>
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
		<div class="col-md-3" style="height: 500px; background: silver;"></div>
		<div class="col-md-9">
		    <div id="all_product">
			<?php
			echo $product;
			?>
			</div>

		</div>
	</div>

	<div class="row">

		<div class="col-md-9 col-md-offset-3">
			<center><button data-count="6" id="show">Показать еще товар</button></center>

		</div>

	</div>

</div>
<script type="text/javascript" src="js/main.js"></script>
</body>

</html>
