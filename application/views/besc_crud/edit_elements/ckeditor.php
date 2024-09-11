<div <?= ($controlled_by) ? 'controlled_by="' . $controlled_by . '" controlled_id="' . $controlled_id . '"' : ''; ?> class="bc_column <?php if (($num_row) % 2 == 0): ?>erow <?php endif; ?>">

	<p class="bc_column_header"><?= $display_as ?>:</p>

	<?php if (isset($col_info) && $col_info != ""): ?>
		<p class="bc_column_info">
			<i><?= $col_info ?></i>
		</p>
	<?php endif; ?>

	<div class="bc_column_input bc_col_ckeditor">

		<textarea height="<?= $height . 'px' ?>" placeholder="<?= $placeholder ?  $placeholder  : '' ?>" class="bc_ck_editor<?= (isset($cfg)) ? $cfg : '' ?>" name="col_<?= $db_name ?>"
			style="<?php if (isset($height))
				echo 'height: ' . $height . 'px;'; ?> <?php if (isset($width))
				echo 'width: ' . $width . 'px;'; ?>"><?php if (isset($value))
				echo $value; ?>
		</textarea>
		
	</div>

</div>

<br>