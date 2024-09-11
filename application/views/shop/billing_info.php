<!-- CSS -->
<link rel="stylesheet" type="text/css" href="<?=site_url("items/frontend/css/shop.css?ver=".time()); ?>">

<!-- JS -->
<script src="<?= site_url("items/frontend/js/shop.js?ver=2"); ?>" type="text/javascript"></script>

<div id="billing_item_container" class="" style="">

	<div id="shopping_steps_holder" style="display:none;">
		<img class="shop_step" src="<?= site_url('items/frontend/img/shop_icons_01.svg')?>" />
		<img class="shop_step" src="<?= site_url('items/frontend/img/shop_icons_03_black.svg')?>" />
		<!--<img class="shop_step" style="width:58px;height:58px;margin-top:0px;" src="<?= site_url('items/frontend/img/shop_icons_02.svg')?>" />-->
		<img class="shop_step"  src="<?= site_url('items/frontend/img/shop_icons_04.svg')?>" style="margin-right:0px;width:68px;"/>
	</div>

	<div class="cart_title"><?= $this->lang->line('billing_info');?></div>
	<div class="billing_description"><?= $this->lang->line('billing_text');?></div>
	<form method="post" id="billing_info_form" style="margin-top:20px;" action="<?= site_url('shop/checkout')?>">
		<label class="module_contact_label register_input" >Firstname *</label>
		<label class="module_contact_label register_input" >Lastname *</label>

		<input type="text" placeholder="" name="firstname" class="register_input" value="<?= $firstname;?>"></input>
		<input type="text" style="margin-right:0px;" placeholder="" name="lastname" class="register_input" value="<?= $lastname;?>"></input>


		<label class="module_contact_label register_input" >Company</label>
		<label class="module_contact_label register_input" >Uid</label>

		<input type="text" placeholder="" name="company" class="register_input" value="<?= $company;?>"></input>
		<input type="text" style="margin-right:0px;" placeholder="" name="uid" class="register_input" value="<?= $uid;?>"></input>

		<label class="module_contact_label register_input" ><?= $this->lang->line('country')?> *</label>
		<select id="billing_country" name="billing_country">
			<?php if(!isset($country_select)):?>
				<option value="" selected disabled><?= $this->lang->line('country') ?></option>
			<?php endif;?>
			<?php foreach($countries as $country):?>
				<option value="<?= $country->id ?>" <?php if($country_select == $country->id) echo 'selected'?>><?= ($lang == MAIN_LANGUAGE)? $country->name_de : $country->name_en; ?></option>
			<?php endforeach;?>
		</select>





		<label class="module_contact_label register_input" ><?= $this->lang->line('street')?> *</label>

		<input type="text" style="width:calc(100% - 20px);margin-right:0px;" placeholder="" name="street" class="register_input" value="<?= $street;?>"></input>


		<label class="module_contact_label register_input" style="width:150px;" >Street Nr. *</label>
		<label class="module_contact_label register_input" style="margin-right:0px;width:150px" >Stair/Door *</label>

		<input type="text" style="width:150px;" placeholder="" name="street_nr" class="register_input" value="<?= $street_nr;?>"></input>
		<input type="text" style="margin-right:0px;width:150px" placeholder="" name="door_stair" class="register_input" value="<?= $stair_door;?>"></input>



		<label class="module_contact_label register_input" style="width:150px;" ><?= $this->lang->line('zip')?> *</label>
		<label class="module_contact_label register_input" style="margin-right:0px;width:608px" ><?= $this->lang->line('city')?> *</label>

		<input type="text" style="width:150px;" placeholder="" name="zip" class="register_input" value="<?= $zip;?>"></input>
		<input type="text" style="margin-right:0px;width:608px" placeholder="" name="city" class="register_input" value="<?= $city;?>"></input>


		<label class="module_contact_label register_input" >E-mail *</label>

		<input type="text" placeholder="" name="email" class="register_input" style="width:calc(100% - 20px);" value="<?= $email;?>"></input>


		<label class="module_contact_label register_input" style="width: 100%;" ><?= $this->lang->line('phone')?></label>

		<input type="text" placeholder="" name="phone" style="margin-right:0px;" class="register_input" value="<?= $phone;?>"></input>


		<div style="width:285px;margin-right:0px;float:left;">
				<input type="checkbox" id="nl" name="newsletter" style="margin-top:10px;width:20px;float:left;height: 20px; margin-left: 10px;" class="" value="1"></input>
				<div style="float:left;height:30px;line-height:38px; font-size: 22px;"><?= $this->lang->line('sub_nl')?></div>
		</div>

		<div style="width:285px;margin-right:0px;float:left;">
			<input type="checkbox" id="agb" name="agb" style="margin-top:10px;width:20px;float:left;height: 20px; margin-left: 10px; " class="" value="1"></input>
			<a target="_blank" href="<?= site_url('nutzungsbedingungen')?>">
				<div style="float:left;height:30px;line-height:38px;text-decoration: underline; font-size: 22px;">AGB</div>
			</a>
		</div>

			<br style="clear:both;"/>

		<div style="width:calc(100% - 20px);height:30px;">
			<input type="checkbox" id="diff_delivery" name="diff_delivery" style="margin-top:10px;width:20px;height: 20px; " class="" value="1"></input>
			<div style="float:left;height:30px;line-height:38px;font-size: 22px;">Alternative Lieferadresse</div>
		</div>
	<!-- Diff Delivery -->
			<div id="diff_delivery_holder" style="margin:20px 0px 0px">
				<label class="module_contact_label register_input" >Name *</label>

				<input type="text" placeholder="" name="delivery_name" class="register_input" value="Name" style="width:calc(100% - 20px)"></input>


				<label class="module_contact_label register_input" ><?= $this->lang->line('country')?> *</label>
        		<select id="delivery_country" name="delivery_country">
        			<?php if(!isset($country_select)):?>
        				<option value="" selected disabled><?= $this->lang->line('country') ?></option>
        			<?php endif;?>
        			<?php foreach($countries as $country):?>
        				<option value="<?= $country->id ?>" <?php if($country_select == $country->id) echo 'selected'?>><?= ($lang == MAIN_LANGUAGE)? $country->name_de : $country->name_en; ?></option>
        			<?php endforeach;?>
        		</select>


        		<select id="delivery_state" name="delivery_state">
        			<option value="" selected disabled><?= $this->lang->line('county') ?></option>
        			<option value="1">Wien</option>
        			<option value="2">NÖ</option>
        			<option value="3">OÖ</option>
        			<option value="4">Burgenland</option>
        			<option value="5">Steiermark</option>
        			<option value="6">Kärnten</option>
        			<option value="7">Salzburg</option>
        			<option value="8">Tirol</option>
        			<option value="9">Vorarlberg</option>
        		</select>


        		<label class="module_contact_label register_input" ><?= $this->lang->line('street')?> *</label>

        		<input type="text" style="width:calc(100% - 20px);margin-right:0px;" placeholder="" name="delivery_street" class="register_input" value="<?= $street;?>"></input>


        		<label class="module_contact_label register_input" style="width:150px;" ><?= $this->lang->line('zip')?> *</label>
        		<label class="module_contact_label register_input" style="margin-right:0px;width:607px" ><?= $this->lang->line('city')?> *</label>

        		<input type="text" style="width:150px;" placeholder="" name="delivery_zip" class="register_input" value="<?= $zip;?>"></input>
        		<input type="text" style="margin-right:0px;width:607px" placeholder="" name="delivery_city" class="register_input" value="<?= $city;?>"></input>
			</div>




		<br style="clear:both;"/>
		<div id="error_message_register" style="margin-bottom: 10px;"><?= $message_billing;?></div>
		<div style="width:calc(100% - 20px);font-size:30px;text-align:center;"><?= $this->lang->line('optional_info')?></div>
		<div class="billing_description"><?= $this->lang->line('mandatory_tooltip');?></div>

	</form>


		<div id="to_checkout" class="new_btn_style ">Checkout</div>
</div>