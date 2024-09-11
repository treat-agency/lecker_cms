<?
$display = $disabled == true ? 'style="visibility:hidden"' : '';
?>
<div <?= $display ?> class="bc_column <?php if (($num_row) % 2 == 0): ?>erow<?php endif; ?>" col_name="<?= $db_name ?>" <?= ($controlled_by) ? 'controlled_by="' . $controlled_by . '" controlled_id="' . $controlled_id . '"' : ''; ?>>
	<p class="bc_column_header">
		<?= $display_as ?>:</p>

	<?php if (isset($col_info) && $col_info != ""): ?>
			<p class="bc_column_info"> <i><?= $col_info ?></i> </p>
	<?php endif; ?>

	<div class="bc_column_input bc_col_select ">
		<select <?= $disabled ? 'disabled' : '' ?> class="select-basic-single ui-rounded1" name="col_<?= $db_name ?>" <?= ($control) ? 'controlling_element="' . $control . '"' : ''; ?>>

			<?php foreach ($options as $option): ?>
					<option value="<?= $option['key'] ?>" <?
						if ($control == 'article_type' && $option['key'] == $article_type) {
							echo 'selected';
						} ?>		<?php if (isset($value) && $value == $option['key'])
									echo "SELECTED"; ?>>
						<?= $option['value'] ?>
					</option>
			<?php endforeach; ?>

		</select>
	</div>

	<div class="bc_error_text"></div>

</div>

<br> 