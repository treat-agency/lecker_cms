<div class="bc_column <?php if (($num_row) % 2 == 0) : ?>erow<?php endif; ?>" col_name="<?= $db_name ?>">
	<p class="bc_column_header"><?= $display_as ?>:</p> <?php if (isset($col_info) && $col_info != "") : ?> <p class="bc_column_info"> <?= $col_info ?> </p> <?php endif; ?>
	<div class="bc_column_input bc_col_colorpicker"> <input type="text" name="col_<?= $db_name ?>" value="<?php if (isset($value)) : ?><?= $value; ?><?php endif; ?>" <?php echo $hexinput ? ' hexinput=1 ' : ' hexinput=0 ' ?>> </div>
	<div class="bc_error_text"></div>
</div>