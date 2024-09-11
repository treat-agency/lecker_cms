<div <?= ($controlled_by) ? 'controlled_by="' . $controlled_by . '" controlled_id="' . $controlled_id . '"' : ''; ?>
  class="bc_column <?= (($num_row) % 2 == 0)? "erow":''; ?>" col_name="<?= $db_name ?>" table_name="<?= $table_name ?>"
  row_id="<?=$row_id?>">
  <p class="bc_column_header">
    <?= $display_as ?>:
  </p>
  <?php if (isset($col_info) && $col_info != "") : ?>
  <p class="bc_column_info">
    <i><?= $col_info ?></i>
  </p>
  <?php endif; ?>
  <div class="bc_column_input bc_col_repo_text">

    <select class="bc_select_text" name="<?= $db_name ?>_select">
    </select>

    <textarea class="bc_textarea_text" name="<?= $db_name ?>_text" rows="5" cols="50"></textarea>

  </div>
  <div class="bc_error_text"></div>
</div>