<!-- CSS -->
<link rel="stylesheet" type="text/css" href="<?=site_url("items/frontend/css/shop.css?ver=".time()); ?>">

<!-- JS -->


<div id="item_container" class="" style="margin-top:15px;">
	
	<div id="shopping_steps_holder">
		<img class="shop_step" src="<?= site_url('items/frontend/img/shop_icons_01_black.svg')?>" />
		<img class="shop_step" src="<?= site_url('items/frontend/img/shop_icons_03.svg')?>" />
		<!--<img class="shop_step" style="width:58px;height:58px;margin-top:0px;" src="<?= site_url('items/frontend/img/shop_icons_02.svg')?>" />-->
		<img class="shop_step"  src="<?= site_url('items/frontend/img/shop_icons_04.svg')?>" style="margin-right:0px;width:68px;"/>
	</div>
	
	
	
	<div class="cart_title"><?= $this->lang->line('cart_title')?></div>
	
	<div id="cart_overview">
	
	<?php if(count($cartitems) > 0):?>
		
		
		<table style="width:100%;">
			<thead style="">
				<th style="text-align:left;"><?= $this->lang->line('shop_product');?></th>							
				<th style="text-align:right;"><?= $this->lang->line('shop_price_net');?></th>
				<th style="text-align:right;"><?= $this->lang->line('shop_price_tax');?></th>
				<th style="text-align:right;"><?= $this->lang->line('shop_price_gross');?></th>
				<th style="text-align:right;"></th>
			</thead>
			<tbody>
				<?php  foreach($cartitems as $item):?>
					<tr class="table_space"></tr>
					<tr class="cart_item" rowid="<?= $item['rowid']?>">
						<td style="width:40%">
							<div class="cart_item_text" rowid="<?= $item['rowid']?>">
					        	<div class="cart_item_qty" iid="<?= $item['id']; ?>">
					        	
					        		<?php if($item['id'] != 7 && $item['id'] != 8): ?>
	    					        	<div class="cart_item_qty_btn more noselect">+</div> 
	    					            <div class="cart_item_qty_qty" >
	    						            <span class="qty_num"><?= $item['qty']?></span>  x <div class="cart_item_name" style="margin-left:5px;float:right;"><span> <?= " ".$item['name']?></span></div></div>
	    					            <div class="cart_item_qty_btn less noselect">-</div>
						            
						            <?php else: ?>
	    					            <div class="cart_item_qty_qty" >
	    						            <span class="qty_num"><?= $item['qty']?></span>  x <div class="cart_item_name" style="margin-left:5px;float:right;"><span> <?= " ".$item['name']?></span></div></div>
						            <?php endif; ?>
						        </div>
					        </div>
					    </td>
						
						<td style="width:18%"><div class="cart_item_price price_net">€ <?= number_format((float)$item['qty'] * $item['options']['price_net'], 2, ',', '') ?></div></td>
						<td style="width:18%"><div class="cart_item_price price_tax">€ <?= number_format((float)$item['qty'] * $item['options']['price_tax'], 2, ',', '') ?></div></td>				
						<td style="width:18%"><div class="cart_item_price">€ <?= number_format((float)$item['qty'] * $item['price'], 2, ',', '') ?></div></td>
						<td style="width:6%" ><div class="cart_item_delete" style="">X</div></td>
					</tr>
				<?php endforeach;?>
				
			</tbody>
		</table>

		<hr class="" style="width:100%;height:2px; border:0;margin:10px auto;background:#000;">
		
			<div id="promo_holder">
				<? if(!$promo):?>
					<div>Promo code:</div>
					<input type="text" name="" id="promo_code" />
					<div id="add_promo_code" class="button">Add promo code</div>
				<? else: ?>
					<div id="remove_promo_code" class="button">Remove promo code</div>
				<? endif;?>
			</div>
		
		
		<div id="cart_total" style="<?php if(count($cartitems) <= 0):?>display: none;<?php endif;?>">Gesamt: <div style="text-align:right;float:right" id="total_sum">€ <?= number_format((float)$total, 2, ',', '')?> </div></div>
		
			<div id="discount_holder">
				<? if($promo != false):?>
					Discount <span id="promo_text">(<?= $promo['code']?>)</span>: <div style="text-align:right;float:right" id="discount_sum">€ -<?= $promo['discount']?></div><br/>
					Total after discount: <div style="text-align:right;float:right" id="total_discount_sum">€ <?= $promo['total']?></div><br/>
					<br/>
				<? endif ?>
				<div id="discount_error"></div>
			</div>
		
		<br/>
		<br/>
		
		
		<div><?= $this->lang->line('ticket_tooltip');?></div>
		<br/>
		
		
		<a href="<?= site_url('billing_info');?>">
			<div id="cart_checkout" class="new_btn_style" style="<?php if(count($cartitems) <= 0):?>display: none;<?php endif;?>">Checkout</div>
		</a>
	
	<? else:?>
		<div style="text-align:center"><?= $this->lang->line('cart_empty');?></div>
	<? endif;?>
	<?php if(count($cartitems) > 0):?>
		<div id="cart_empty"  class="new_btn_style" style="<?php if(count($cartitems) > 0):?>display: block !important;<?php endif;?>">Empty cart</div>
	<? endif;?>
	</div>
	
	
	

</div>