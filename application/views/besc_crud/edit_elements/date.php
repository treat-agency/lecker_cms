<div
  class="bc_column <?= ($controlled_by) ? 'controlled_by="' . $controlled_by . '" controlled_id="' . $controlled_id . '"' : ''; ?> <?php if (($num_row) % 2 == 0) : ?>erow<?php endif; ?>"
  col_name="<?= $db_name ?>">
  <p class="bc_column_header"><?= $display_as ?>:</p> <?php if (isset($col_info) && $col_info != "") : ?> <p
    class="bc_column_info"> <i><?= $col_info ?></i> </p> <?php endif; ?>
  <div class="bc_column_input bc_col_date">
    <input type="text" name="col_<?= $db_name ?>" format="<?= $edit_format ?>" value="<?= $corr_value ?>">
    <img class="bc_col_date_calendar" src="<?= site_url('items/besc_crud/img/calendar_icon.png') ?>" />
    <img class="bc_col_date_reset" src="<?= site_url('items/besc_crud/img/delete.png') ?>" />
  </div>
  <div class="bc_error_text"></div>
</div>