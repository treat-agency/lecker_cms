$(document).ready(function()
{
	addShopListeners_();
	addCustomerListeners();

});

function addCustomerListeners()
{
	$('#menu_login').click(function()
	{
		$('#login_holder').show();
	});

	$('#close_login_overlay').click(function()
	{
		$('#login_holder').fadeOut();
	});


	$('#pw_forgot').click(function()
	{
		$('#login_holder').hide();
		$('#forgot_holder').show();
	});

	$('#close_forgot_overlay').click(function()
	{
		$('#forgot_holder').hide();
		$('#login_holder').show();

	});

	$('#go_register').click(function()
	{
		window.location.href = rootUrl+'registration';

	});



	$('#customer_register').click(function(){

		$(this).hide();
		$('#register_customer_form').submit();

	});


	$('#register_customer_form').on('submit',function(e){
		e.preventDefault();

		var formdata = $(this).serialize();

		$.ajax(
		{
			url: rootUrl + 'Shop/register_customer',
			data: formdata,
			method: 'POST',
			success: function(data)
			{
				var json = $.parseJSON(data);
				if(json.success == true)
				{
					$('#register_success').empty().html(json.msg);

				}
				else
				{
					$('#register_error').empty().html(json.msg);
				}
				$('#customer_register').show();

			}
		});

	});



	$('#send_customer_login').on('click',function(e){
		e.preventDefault();
		$this = $(this);


		var user = $('#login_user').val();
		var pw = $('#login_pw').val();

		if(user != '' && pw != '')
		{
			$this.hide();
			$.ajax(
			{
				url: rootUrl + 'Shop/customer_login',
				data: {user: user, pw:pw},
				method: 'POST',
				success: function(data)
				{
					var json = $.parseJSON(data);
					if(json.success == true)
					{
						location.reload();

					}
					else
					{
						$('#login_error').empty().html(json.msg);
						$this.show();
					}


				}
			});
		}
		else
		{
			$this.show();
			$('#login_error').text('');
		}



	});

	$('#menu_logout').on('click',function(e){
		e.preventDefault();

		$.ajax(
		{
			url: rootUrl + 'Shop/customer_logout',
			data: {},
			method: 'POST',
			success: function(data)
			{
				location.reload();


			}
		});

	});
}




function addShopListeners_()
{




	$('#remove_promo_code').click(function(){

		$.ajax(
		{
			url: rootUrl + 'Shop/removePromoCode',
			data: {},
			method: 'POST',
			success: function(data)
			{

				location.reload();

			}
		});


	});

	$('#add_promo_code').click(function(){

		var code = $('#promo_code').val();

		$.ajax(
		{
			url: rootUrl + 'Shop/addPromoCode',
			data: {promo_code:code},
			method: 'POST',
			success: function(data)
			{
				var json = $.parseJSON(data);
				if(json.success == true)
				{
					$('#discount_error').empty().text(json.msg);
					location.reload();
				}
				else
				{
					$('#discount_error').empty().text(json.msg);
				}


			}
		});


	});



	$('#diff_delivery').on('change', function()
	{
		if($(this).is(':checked'))
		{
			$('#diff_delivery_holder').show();
			$('#footer_holder').css({'position': 'sticky'})

		}
		else
		{
			$('#diff_delivery_holder').hide();
		}
	})


	$('#billing_country').on('change', function()
	{
		var val = $(this).val();

		if(val == "AT")
		{
			$('#billing_state').show();
		}
		else
		{
			$('#billing_state').hide();
			$('#billing_state').val('');
		}
	});


	$('#delivery_country').on('change', function()
	{
		var val = $(this).val();

		if(val == "AT")
		{
			$('#delivery_state').show();
		}
		else
		{
			$('#delivery_state').hide();
			$('#delivery_state').val('');
		}
	});


	$('.cart_item_delete').on('click', function(e)
	{
		e.stopImmediatePropagation();

		removeItem($(this).parent().parent().attr('rowid'));

	});

	$('.payment_label').click(function(){
		$('.payment_label').removeClass('active');
		$(this).addClass('active');
		$(this).find('input').click();
	});

	$('.add_to_cart').click(function(){
		var pid = $(this).attr('sid');

		addToCart(pid, 1, 'product');


	});

	$('#to_checkout').click(function(){
		$('#billing_info_form').submit();
	});


	$('#cart_empty').click(function(){

		$.ajax(
		{
			url: rootUrl + 'Shop/clearCart/',
			data: {},
			method: 'POST',
			success: function(data)
			{
				window.location.href = rootUrl;

			}
		});


	});


	$('.cart_item_qty_btn').on('click', function()
	{
		console.log('click')
		if($(this).hasClass('less'))
		{
			if($(this).parent().attr('iid') == 9)
			{
				if($(this).parent().find('.cart_item_qty_qty').find('.qty_num').text() > 10)
				{
					updateItemCartQty($(this).parent().parent().attr('rowid'), -1);
				}
			}
			else
			{
				updateItemCartQty($(this).parent().parent().attr('rowid'), -1);
			}
		}
		else
		{
			updateItemCartQty($(this).parent().parent().attr('rowid'), 1);
		}
	});

}

function removeItem(rowId)
{
	$.ajax(
	{
		url: rootUrl + 'Shop/removeFromCart/',
		data: {'rowId': rowId},
		method: 'POST',
		success: function(data)
		{
			var ret = $.parseJSON(data);
			if(ret.success)
			{


				window.location.reload();

					/*$('.cart_item[rowid="' + rowId + '"]').fadeOut(150, function()
					{

						$('#total_sum').empty().text(ret.total+" €");
						if($('.cart_item').length <= 0)
						{
							window.location.reload();
						}
					});*/
				}


		}
	});
}



function addToCart(product_id, qty, type)
{

	$.ajax(
	{
		url: rootUrl + 'Shop/addToCart',
		data: { 'sid': product_id, 'qty': qty, 'type': type},
		method: 'POST',
		cache: false,
		success: function(data)
		{
			var ret = $.parseJSON(data);
			$('#cart_holder').show();
			$('#cart_num').html(ret.count).show();
		}
	});
}



function updateCart()
{
	$.ajax(
	{
		url: rootUrl + 'Shop/getCartItemCount',
		data: {},
		method: 'GET',
		success: function(data)
		{
			var ret = $.parseJSON(data);

			/*if(ret.count > 0)
				$('#cart_itemcount').html(ret.count).show();
			else
				$('#cart_itemcount').html(ret.count).hide();
			*/
		}
	});
}

function updateItemCartQty(rowId, change)
{
	$.ajax(
	{
		url: rootUrl + 'Shop/updateItemCartQty/',
		data: {'rowId': rowId, 'change': change},
		method: 'POST',
		success: function(data)
		{
			var ret = $.parseJSON(data);
			if(ret.success)
			{
				location.reload();
				/*
				updateCart();
				if(ret.count > 0)
				{
					$('.cart_item[rowid="' + rowId + '"]').find('.qty_num').empty().text(ret.count);
					$('.cart_item[rowid="' + rowId + '"]').find('.cart_item_price').empty().text(ret.price+" €");
					$('.cart_item[rowid="' + rowId + '"]').find('.cart_item_price.price_net').empty().text(ret.price_net+" €");
					$('.cart_item[rowid="' + rowId + '"]').find('.cart_item_price.price_tax').empty().text(ret.price_tax+" €");
					$('#total_sum').empty().text(ret.total+" €");
				}
				else
					$('.cart_item[rowid="' + rowId + '"]').fadeOut(150, function()
					{
						$(this).remove();
						$('#total_sum').empty().text(ret.total+" €");
						if($('.cart_item').length <= 0)
						{
							$('#cart_total').fadeOut(150);
							$('#cart_empty').fadeIn(150);
							$('#cart_checkout').fadeOut(150);
						}
					});
					*/
			}
		}
	});
}
