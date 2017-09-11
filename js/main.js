$('#show').on('click', function(){
	var data_count = $(this).attr("data-count");

	$.ajax({

		url: "http://first.loc/handler.php",
		type: "POST",
		data: "target=show&data_count="+data_count,
		success: function(data){
			if(data != 'Empty'){

			$('#all_product').append(data);
  	        var count  = parseInt(data_count) + parseInt(3);

			$('#show').attr('data-count', count);
			console.log(data);
		}else{
			$('#show').hide();
			console.log(data);
		}



	}

});

});

$('body').on('click','.to-cart', function(){

	var data_id = $(this).attr("data-id");

	$.ajax({
		url: "http://first.loc/handler.php",
		type: "POST",
		data: "target=to_cart&id="+data_id,
		success: function(data){
		
			if(data == 1){



				


				var cart_count = $('#cart_count span').html();
				cart_count = parseInt(cart_count) + parseInt(1);
                $('#cart_count span').html(cart_count);



                $('#alert').addClass('alertShow');
				setTimeout(function() {
				$('#alert').removeClass('alertShow');	
				},1000);
			}
		}


	});
});

$('.minus').on('click', function(){

	var data_id = $(this).attr("data-id");

	$.ajax({
		url: "http://first.loc/handler.php",
		type: "POST",
		data: "target=cart_minus&id="+data_id,
		success: function(data){
			
			window.location.href = window.location.href;
		}
	});

});

$('.plus').on('click', function(){
	
	var data_id = $(this).attr("data-id");

	$.ajax({
		url: "http://first.loc/handler.php",
		type: "POST",
		data: "target=cart_plus&id="+data_id,
		success: function(data){

			if(data == 1){


			window.location.href = window.location.href;

			}else if(data == 0){
				alert("На складе нет такого количества товара");
			}
		}
	});

});

$('.delete').on('click', function(){

	
	var data_id = $(this).attr("data-id");
	console.log(data_id);
	$.ajax({
		url: "http://first.loc/handler.php",
		type: "POST",
		data: "target=cart_delete&id="+data_id,
		success: function(data){
			console.log(data);
			window.location.href = window.location.href;
		}
});
});