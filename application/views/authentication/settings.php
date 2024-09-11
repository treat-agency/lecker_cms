
    	<div id="settings_container">
			<div class="content_h1" style="margin-top:50px;">Settings</div>
			<a href="<?= site_url() . 'entities/Content/page_settings/edit/1' ?>">
			<button class = "leckerButton">Page</button>
			</a>
			<a href="<?= site_url() . 'entities/Content/lecker_dashboard' ?>">
			<button class = "leckerButton">Dashboard</button>
			</a>
			<a href="<?= site_url() . 'entities/Content/google_analytics' ?>">
			<button class = "leckerButton">Google Analytics</button>
			</a>
			<!--
			<a href="<?= site_url() . 'google_analytics' ?>">
			<button class = "leckerButton">Areas</button>
			</a>
			<a href="<?= site_url() . 'entities/Content/lecker_menus' ?>">
			<button class = "leckerButton">Menus</button>
			</a>
			<a href="<?= site_url() . 'entities/Content/lecker_submenus' ?>">
			<button class = "leckerButton">Submenus</button>
			</a> -->
			<div class="content_h1" style="margin-top:50px;">User</div>
    		<form id="settings_form" action="<?= site_url('authentication/updateUser')?>" method="post">
	    		<input type="hidden" name="userid" id="userid" value="<?= isset($user) ? $user->id : set_value('userid')?>" readonly/>

				<label for="username">Username</label>
				<input type="text" name="username" id="username" value="<?= isset($user) ? $user->username : set_value('username')?>" readonly/>

				<label for="firstname">Firstname</label>
				<input type="text" name="firstname" id="firstname" value="<?= isset($user) ? $user->firstname : set_value('firstname')?>" />

				<label for="lastname">Lastname</label>
				<input type="text" name="lastname" id="lastname" value="<?= isset($user) ? $user->lastname : set_value('lastname')?>" />

				<label for="email">E-Mail</label>
				<input type="text" name="email" id="email" value="<?= isset($user) ? $user->email : set_value('email')?>" />
				<br/><br/>
				<label for="pword">New password</label>
				<input type="password" name="pword" id="pword" value="" />

				<label for="pword2">Confirm password</label>
				<input type="password" name="pword2" id="pword2" value="" />

				<input type="submit" id="updatebutton" value="Update" />

    		</form>
    		<h2 id="errormessage"><?= isset($success) && $success ? 'Settings updated' : validation_errors(); ?></h2>


    	<!-- 	    <? if( ($userdata->is_admin == 1 || $userdata->access_bildland == 1 || $userdata->access_diktaturen == 1 || $userdata->access_multimediale == 1 || $userdata->access_postkarten == 1 || $userdata->access_website == 1 || $userdata->access_personal == 1 || $userdata->access_heldenplatz == 1)):?>
    		    <div class="add_quicklinks">
    		    	<div class="content_h1" style="margin-top: 10px;">My quicklinks</div>

		    		<div id="quicklink_btn">Add Quicklink <i class="material-icons">add_circle_outline</i></div>
		    		<div id="my_quicklink_holder">
		    			<? foreach($menupoints as $mp):?>
		    				<div class="quicklink_item" qid="<?= $mp->id?>" ><?= $mp->category." - ".$mp->short_text;?><div class="delete_quicklink">✕</div></div>
		    			<? endforeach;?>
		    		</div>
				<? endif;?> -->
				<div>
    	</div>
