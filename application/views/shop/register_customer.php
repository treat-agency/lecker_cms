<div id="register_holder">
		<div class="overlay_title">Registrierung</div>
		<div class="overlay_text" id="regtext">Mit (*) Sternchen gekennzeichnete Felder sind Pflichtfelder.</div>
		<div id="register_success"></div>
		<form id="register_customer_form" action="" method="post">

    		<!-- <div class="field-item full">
    			<label class="" for="reg_overlay_anrede">Anrede</label>
				<select class="reg_select" name="spende_anrede" id="reg_overlay_anrede">
					<option value="Herr">Herr</option>
					<option value="Frau">Frau</option>
					<option value="Firma">Firma</option>
				</select>
    		</div>

    		<div class="field-item full">
    			<label class="visuallyhidden" for="reg_overlay_titel">Titel</label>
    			<input class="register_input" type="text" name="titel" value="" id="reg_overlay_titel" placeholder="Titel">
    		</div>
    		 -->
    		<div class="field-item full">
    			<label class="visuallyhidden" for="reg_overlay_vorname">Vorname*</label>
    			<input class="register_input" type="text" name="vorname" value="" id="reg_overlay_vorname" placeholder="Vorname*">
    		</div>

    		<div class="field-item full">
    			<label class="visuallyhidden" for="reg_overlay_nachname">Nachname*</label>
    			<input class="register_input" type="text" name="nachname" value="" id="reg_overlay_nachname" placeholder="Nachname*">
    		</div>

    		<div class="field-item full">
    			<label class="visuallyhidden" for="reg_overlay_email">E-Mail*</label>
    			<input class="register_input" type="text" name="email" value="" id="reg_overlay_email" placeholder="E-Mail*">
    		</div>

    		<div class="field-item full">
    			<label class="visuallyhidden" for="reg_overlay_firmenname">Firmenname</label>
    			<input class="register_input" type="text" name="firmenname" value="" id="reg_overlay_firmenname" placeholder="Firmenname">
    		</div>

    		<div class="field-item full">
    			<label class="" for="reg_overlay_land">Land</label>
				<select class="reg_select" name="spende_land" id="reg_overlay_land">
					<?php foreach($countries as $country):?>
						<option value="<?= $country->id ?>"><?= ($lang == MAIN_LANGUAGE)? $country->name_de : $country->name_en ?></option>
					<?php endforeach;?>


				</select>
    		</div>

    		<div class="field-item quarter" style="margin-right:1%;">
    			<label class="visuallyhidden" for="reg_overlay_plz">PLZ*</label>
    			<input class="register_input" type="text" name="zip" value="" id="reg_overlay_plz" placeholder="PLZ*">
    		</div>

    		<div class="field-item threeQuarters">
    			<label class="visuallyhidden" for="reg_overlay_ort">Ort*</label>
    			<input class="register_input" type="text" name="city" value="" id="reg_overlay_ort" placeholder="Ort*">
    		</div>

    		<div class="field-item full">
    			<label class="visuallyhidden" for="reg_overlay_strasse">Straße*</label>
    			<input class="register_input" type="text" name="street" value="" id="reg_overlay_strasse" placeholder="Straße*">
    		</div>

    		<div class="field-item full">
    			<label class="visuallyhidden" for="reg_overlay_strasse">Haus Nr.*</label>
    			<input class="register_input" type="text" name="house_nr" value="" id="reg_house_nr" placeholder="Haus Nr.*">
    		</div>

    		<div class="field-item full">
    			<label class="visuallyhidden" for="reg_overlay_strasse">Door/Staircase</label>
    			<input class="register_input" type="text" name="door_staircase" value="" id="reg_door_staircase" placeholder="Door/Staircase">
    		</div>

    		<div class="field-item full">
    			<label class="visuallyhidden" for="reg_overlay_pw">Passwort*</label>
    			<input class="register_input" type="password" name="password" id="reg_pw" value="" placeholder="Passwort*">
    			<div style="font-size:14px;color:#b7422f;margin-top:5px;">(mind. 6 Zeichen)</div>
    		</div>

    		<div class="field-item full">
    			<label class="visuallyhidden" for="reg_overlay_pw_conf">Passwort bestätigen*</label>
    			<input class="register_input" type="password" name="password_confirm" id="reg_pw_conf" value="" placeholder="Passwort bestätigen*">
    		</div>

    		<div class="field-item full">
    			<label class="visuallyhidden" for="reg_overlay_pw_phone">Telefonnummer</label>
    			<input class="register_input" type="text" name="phone" value="" id="reg_overlay_pw_phone" placeholder="Telefonnummer (+4366412345678)">
    		</div>

    		<div class="field-item full">
    			<input type="checkbox" name="agb" value="1" id="reg_overlay_agb">
    			<label class="" for="reg_overlay_agb">AGB akzeptieren*</label>
    		</div>

        </form>
    	<br>

		<button class="button" id="customer_register">Senden</button>
		<br style="clear:both">
		<div class="click_text" id="register_error" style="margin-top:15px;text-align:center;"></div>
	</div>