<?php session_start();
try{
	$PDO = new PDO("mysql:host=localhost;dbname=base","root","");
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){

  echo  $e->getMessage();
}

if(isset($_POST['target']) && $_POST['target'] == 'show'){
	   $data_count = $_POST['data_count'];

	    $query = $PDO->query("SELECT * FROM product LIMIT $data_count,3");
		$match = $query->fetch(PDO::FETCH_ASSOC);

	    if(!empty($match['product_id'])){

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
						</div>
				";
		    }//end if
		}//end while

echo $product;
}else{
	echo "Empty";
}


}//end if show


if(isset($_POST['target']) && $_POST['target'] == 'to_cart'){

	if(is_numeric($_POST['id'])){
		$res = $PDO->query("SELECT * FROM product WHERE product_id = '$_POST[id]' AND product_sklad > 0")->fetch(PDO::FETCH_ASSOC);
		if(!empty($res['product_id'])){
			if(!isset($_SESSION['cart'])){
				$_SESSION['cart'] = array();
			}
			if(!isset($_SESSION['cart'][$res['product_id']])){


			$_SESSION['cart'][$res['product_id']] = $res;
			$_SESSION['cart'][$res['product_id']]['count'] = 1;
			echo 1;
			}else{
            
            ++$_SESSION['cart'][$res['product_id']]['count'];
         	echo 1;
			}
		}
	}

}
/*---------------minus--------------------*/
if(isset($_POST['target']) && $_POST['target'] == 'cart_minus'){

$id = $_POST['id'];

if($_SESSION['cart'][$id]['count'] > 1){
	$_SESSION['cart'][$id]['count'] = $_SESSION['cart'][$id]['count'] - 1;
	echo 1;
}elseif($_SESSION['cart'][$id]['count'] == 1){
	unset($_SESSION['cart'][$id]);
	echo 2;
}

}

/*---------------plus--------------------*/
if(isset($_POST['target']) && $_POST['target'] == 'cart_plus'){

$id = $_POST['id'];
$res = $PDO->query("SELECT product_sklad FROM product WHERE product_id = '$id'")->fetch(PDO::FETCH_ASSOC);

if($res['product_sklad'] > 1 && $_SESSION['cart'][$id]['count'] <= $res['product_sklad'] - 1){
	$_SESSION['cart'][$id]['count'] = $_SESSION['cart'][$id]['count'] + 1;
	echo 1;
}else{
	echo 0;
}



}

/*---------------delete--------------------*/
if(isset($_POST['target']) && $_POST['target'] == 'cart_delete'){

	$id = $_POST['id'];
	unset($_SESSION['cart'][$id]);

}
?>