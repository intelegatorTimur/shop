<?php
try{
	$PDO = new PDO("mysql:host=localhost;dbname=base","root","");
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){

  echo  $e->getMessage();
}


$query = $PDO->query("SELECT * FROM category");

while ($result = $query->fetch()) {
	$option .= "<option value='$result[categoty_id]'>$result[category_name]</option>";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<link rel="stylesheet" type="text/css" href="css/farbtastic.css">
<link rel="stylesheet" type="text/css" href="style.css">

<script
  src="https://code.jquery.com/jquery-3.2.0.js"
  integrity="sha256-wPFJNIFlVY49B+CuAIrDr932XSb6Jk3J1M22M3E2ylQ="
  crossorigin="anonymous">
  </script>
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="js/farbtastic.js"></script>
  </head>
<form enctype="multipart/form-data" method="post">
<ul>
	<li><input type="text" name="product_name" placeholder="Название товара"></li>
	<li><select name="product_category"><option>Выберите категорию</option>
<?php
echo $option;
?>
	</select></li>
	<li><textarea name ="product_description"></textarea></li>
	<li><input type="number" name="product_price" placeholder="Цена"></li>
	<li><input type="number" name="product_sale" placeholder="Скидка"></li>
	<div class="bx1">
 	<div id="colorpicker"></div>
 	<div id="color2" style= "border : 1px solid black;"></div>
 	</div>
   <div class="bx2">
   <ul>
   </ul>
   </div>
    <div class="clear"></div>

  	<input type="hidden" id="color" value="#123456"/>
  	<div id = "hid" style="visibility: hidden;"></div>
	<a id="btn">Добавить цвет к товару</a>
	<li><input type="hidden" id="currentColor" name="product_color" value="" placeholder="Цвет товара"></li>
	<li><input type="file" name="foto[]" multiple></li>
	<li><input type="checkbox" name="product_visible" checked="checked" value="1">Отображать на сайте</li>
	<li><input type="text" name="meta_title" placeholder="meta-title"></li>
	<li><input type="text" name="meta_keywords" placeholder="meta-keywords"></li>
	<li><input type="text" name="meta_descriptions" placeholder="meta-description"></li>
	<li><input type="submit" name="submit" value="Send"></li>
</ul>


</form>

 <script>

	 tinymce.init({ selector:'textarea' });
	 $('#colorpicker').farbtastic('#color');
	 $('#colorpicker').click(function() {

	 	var color = $('#color').val();
	 	
	 $('#color2').css({'background' : color});
     });

	 $('#btn').on('click', function(){
          var color = $('#color').val();
	 	  $('#hid').append(color);
	 	  $('#currentColor').val($('#hid').html());
	 	  $('.bx2 ul').append('<li class = "selectedCol" data-color="'+color+'" style="background:'+color+'"></li>');

	 });
	 $('body').on('click','.selectedCol',function (){
	 	var data_color = $(this).attr('data-color');
	 	var hid = $('#hid').html();
	 	hid = hid.replace(data_color,'');
	 	$('#hid').html(hid);
	 	$('#currentColor').val(hid);
	 	$(this).detach();
	 });
	 

 </script>

<?php
$arr = [];

if(isset($_POST['submit'])){
	$count = count($_FILES['foto']['name']);
	for ($i=0; $i <= $count; $i++) { 

		$move = move_uploaded_file($_FILES['foto']['tmp_name'][$i], $_SERVER['DOCUMENT_ROOT'].'/download/'.$_FILES['foto']['name'][$i]);
		if($move){
			array_push($arr, $_FILES['foto']['name'][$i]);
		}
	}

	$img = implode(',', $arr);

	//print_r($_FILES['foto']);
$product_name = addslashes($_POST['product_name']);
$product_description = addslashes($_POST['product_description']);

	$query1 = $PDO->prepare("INSERT INTO product (product_name, product_description, product_price, product_color, product_image, product_visible, meta_title, meta_keywords, meta_descriptions, product_sale, product_category) 

		VALUES 

		('$product_name',
		'$product_description',
		'$_POST[product_price]',
		'$_POST[product_color]',
		'$img',
		'$_POST[product_visible]',
		'$_POST[meta_title]',
		'$_POST[meta_keywords]',
		'$_POST[meta_descriptions]',
		'$_POST[product_sale]',
		'$_POST[product_category]') ");

	if($query1->execute()) {
		echo "<script>alert('All is good!!')</script>";
	}else{
		echo "<script>alert('All is not good!!')</script>";
	}

}

?>
</html>