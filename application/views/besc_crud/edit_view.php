	<link rel="stylesheet" type="text/css" href="<?= site_url("items/general/css/lightbox.css?ver=" . time());?>">
	<link rel="stylesheet" type="text/css" href="<?= site_url("items/general/css/jquery-ui.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?= site_url("items/general/css/jquery-ui.theme.css"); ?>">
		<link rel="stylesheet" type="text/css" href="<?= site_url("items/besc_crud/css/magicsuggest.css"); ?>">

	<link rel="stylesheet" type="text/css" href="<?= site_url("items/besc_crud/css/imgareaselect-default.css"); ?>">
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />


	<script type="text/javascript" src="<?= site_url("items/besc_crud/js/lightbox.min.js"); ?>"></script>
	<script type="text/javascript" src="<?= site_url("items/besc_crud/js/jquery.imgareaselect.min.js"); ?>"></script>
		<script type="text/javascript" src="<?= site_url("items/besc_crud/js/magicsuggest.js"); ?>"></script>


	<script type="text/javascript" src="<?= site_url("items/besc_crud/js/besc_crud.js?ver=" . VERSION); ?>"></script>
	<script type="text/javascript" src="<?= site_url("items/besc_crud/js/besc_crud_edit.js?ver=" . VERSION); ?>"></script>
	<script
		src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js">
	</script>

	<script>


		$(document).ready(function() {

			selectEntity();
		})

		function selectEntity() {
			var sPageURL = window.location.search.substring(1),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {

				sParameterName = sURLVariables[i].split('=');
				if (sParameterName[0] === 'entity_id') {
					$entity_id = decodeURIComponent(sParameterName[1]);
					console.log($entity_id)

					$entity_id = $('.bc_edit_table').find('[col_name = entity_id]').each(function() {
						if ($(this).is(':visible')) {
							var thisOne = $(this).find('option').each(function() {
								if ($(this).attr('value') == $entity_id) {
									$(this).prop('selected', true);
								}
							})
						}
					})


				}
			}
			return false;
		}


	</script>

	<style>

		#create_order_excel {
			display: none
		}

		#content {
			margin-top: 60px;
			/* min-height: calc(100vh - 80px); */
			width: 100%;
			padding: 0;
			max-height: calc(100vh - 60px);
		}

		.bc_edit_table {
			margin-top: 100px;
			padding: 20px 70px 20px;

		}


	</style>



	<script>

		<?php foreach ($bc_urls as $key => $value): ?>
			var <?= $key ?> = "<?= $value ?>";
		<?php endforeach; ?>

		var bc_edit_or_add = "<?= $edit_or_add ?>";


		<?php if (isset($pk_value)): ?>
			var bc_pk_value = "<?= $pk_value ?>";
		<?php endif; ?>

	</script>




	<!-- GENERAL SETTINGS AND ALSO RIGHT MODULES VIEW-->


	<div class="bc_edit_table">

		<!-- <div class="bc_column_actions" style="padding:5px 15px"></div> -->

		<?php foreach ($columns as $column): ?>
			<?= $column ?>
		<?php endforeach; ?>

		<?php include 'articles_into_general_settings.php'; ?>

	</div>
	<br />

	<!-- <? if (count($additional_columns) > 0): ?>
		<div id="btn_dropdown" style="font-family:'HankenGrotesk-Regular';margin:10px 0px;cursor:pointer;">On Loan Info</div>
		<div class="bc_edit_table dropdown" style="display:none;">
			<?php foreach ($additional_columns as $column): ?>
				<?= $column ?>
			<?php endforeach; ?>
		</div>
	<? endif; ?> -->


	<div class="bc_message">
		<div class="bc_message_icon"></div>
		<div class="bc_message_text"></div>
	</div>


	<? if (!$show_mods): ?>
	<div class="bc_column_actions">

		<ul class="gap5">
			<?php if ($edit_or_add == BC_ADD): ?>

				<? if ($is_article && $article_type_name): ?>

					<li class="bc_add basicButton2 invertHover button">Save</li>
					<li class="item_cancel basicButton2 invertHover" article_type_name="<?= $article_type_name ?>">Cancel</li>

				<? else: ?>

					<li class="bc_add basicButton2 invertHover">Save</li>
					<li class="bc_add_cancel basicButton2 invertHover">Cancel</li>

				<? endif; ?>



			<?php else: ?>

					<li class="bc_update basicButton2 invertHover button">Save</li>
					<li class="bc_remove basicButton2 invertHover button" pk_value='<?= $pk_value ?>' table='<?= $table ?>' db_name='<?= $db_name ?>' article_type='<?= $article_type ?>'>Remove</li>

			<? endif; ?>

				<!-- <li class="bc_update_cancel basicButton2 invertHover button">Back</li> -->

		</ul>

	</div>
	<? endif; ?>



	<? if ($show_mods): ?>

	<!-- item_id -->
		<div class="unsavedWarning ui-rounded1">
			Unsaved changes!
		</div>

		<div class="saveModuleButton">
			<span class="unselectable itemSave item_save ui-rounded1 invertHover" title="Speichern" type="html">Save all modules</span>
		</div>
	<? endif; ?>




	<div class="bc_fade" display="none"></div>


  <div class="bc_clone_dialog" style="display: none;">
		<h3> Clone Content </h3>
		<div id="bc_clone_dialog_message" class="bcCloneText"> All modules and content will be moved for translation to the English article. Attention: this will overwrite existing content.
		</div>
		<div class="df-jcc gap5">
			<div class="bc_delete_button basicButton bc_clone_really invertHover clone">Delete</div>
			<div class="bc_delete_button basicButton invertHover bc_clone_cancel">Cancel</div>
		</div>
	</div>

	<div class="bc_delete_dialog" display="none">
		<h3> Delete </h3>
		<p class="bcDeleteText"> Are you sure you want to delete?</p>
		<div class="bc_delete_button js_delete_really">Delete</div>
		<div class="bc_delete_button js_delete_cancel">Cancel</div>
	</div>

	<!-- MODULES -->
<? include(APPPATH . 'views/backend/crud/' . "crud_module_editor.php"); ?>

</div>