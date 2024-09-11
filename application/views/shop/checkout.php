<!-- CSS -->
<link rel="stylesheet" type="text/css" href="<?=site_url("items/frontend/css/shop.css?ver=1"); ?>">

<!-- JS -->
<script src="<?= site_url("items/frontend/js/shop.js"); ?>" type="text/javascript"></script>

<div id="item_container" class="" style="">
	
	<div id="shopping_steps_holder">
		<img class="shop_step" src="<?= site_url('items/frontend/img/shop_icons_01.svg')?>" />
		<img class="shop_step" src="<?= site_url('items/frontend/img/shop_icons_03.svg')?>" />
		<!--<img class="shop_step" style="width:58px;height:58px;margin-top:0px;" src="<?= site_url('items/frontend/img/shop_icons_02_black.svg')?>" />-->
		<img class="shop_step"  src="<?= site_url('items/frontend/img/shop_icons_04_black.svg')?>" style="margin-right:0px;width:68px;"/>
	</div>
	

        
    <script type="text/javascript">
        function pay() {      
         window.location.href = '<?= $userdata['payment_url'] ?>';
        }
    </script>
        

   
    
       
 	<div id="checkout_confirm">
    	<div class="cart_title" ><?= $this->lang->line('your_order')?></div>
    	<br/>
    	<br/>
    	<form  method="post" name="form" >
    	
    	
    		
    		<table border="0" bordercolor="lightgray" cellpadding="10" cellspacing="5" style="width: 100%;">
    			<? foreach($cartitems as $item):?>
    				<tr>
    					
    						<td><span class="qty_num"><?= $item['qty']?></span>  x <?= " ".$item['name']."  (€ ".number_format($item['price'], 2, ',', '').")"?></td>
    					
    					
    					<td style="width:100px;text-align:right;height:25px;">€ <?= number_format((float)$item['qty'] * $item['price'], 2, ',', '') ?></td>
    				</tr>
    			<? endforeach;?>
    			
    			<? if($delivery > 0):?>
    				<tr>
    					<td><span class="qty_num"><?= $this->lang->line('delivery_cost')?></td>
    					<td style="text-align:right;">€ <?= number_format((float)$delivery, 2, '.', '') ?>,-</td>
    				</tr>
    			<? endif;?>
    			
    			<tr style="height:40px;">
    				<td colspan="2"><hr style="height:2px;border:0;width:100%;background:#000;"/></td>
    			</tr>
    			<tr style="padding:5px;">
    				<td align=""><b><?= $this->lang->line('payment_desc');?></b></td>
    				<td style="width:100px;height:30px;text-align:right;"><?php echo $requestParameters["orderDescription"] ?></td>
    			</tr>
    			<tr style="padding:5px;">
    				<td align=""></td>
    				<td style="width:100px;height:30px;text-align:right;"></td>
    			</tr>
                
                <? if($userdata['promo_code'] != NULL):?>
                    <tr>
                        <td>Discount (<?= $userdata['promo_code']?>):</td>
                        <td style="text-align:right;">€ <?= number_format((float)$userdata['discount'], 2, '.', '') ?>,-</td>
                    </tr>
                <? endif;?>
                
    			<tr style="padding:5px;">
    				<td align=""><b><?= $this->lang->line('payment_sum');?></b></td>
    				<td style="width:100px;height:30px;text-align:right;"><?php echo number_format($requestParameters["amount"], 2, ',', '') ?>&nbsp;<?php echo $requestParameters["currency"] ?></td>
    			</tr>
    			<tr>
	    			<td  colspan="2"><div><?= $this->lang->line('payment_tooltip');?></div></td>
    			</tr>
    			
    		<!--	<tr>
	    			<td colspan="2">
		    			<div id="shopping_steps_holder">
							<img class="shop_step" src="<?= site_url('items/frontend/img/shop_icons_01.svg')?>" />
							<img class="shop_step" src="<?= site_url('items/frontend/img/shop_icons_03.svg')?>" />
							<img class="shop_step" style="width:58px;height:58px;margin-top:0px;" src="<?= site_url('items/frontend/img/shop_icons_02.svg')?>" />
							<img class="shop_step"  src="<?= site_url('items/frontend/img/shop_icons_04_black.svg')?>" style="margin-right:0px;width:68px;"/>
						</div>
		    			
	    			</td>
    			</tr>
    		-->	
    			
    			<tr>
    				<td  colspan="2">
                        <input type="button" id="checkout_sub" class="new_btn_style" style="color:white !important;background:black !important;" onclick="pay()" value="<?= $this->lang->line('payment_checkout');?>" />
                    </td>
    				
    			</tr>
    			
    			<tr>
    				<td  colspan="2"><input type="button" id="checkout_sub" class="new_btn_style" style="border:2px solid black" onclick="javascript:window.history.back(-1)" value="Back" /></td>
    				
    			</tr>
    			
    		</table>
    		
    	</form>
    	
    	
    	
	</div>


</div>


