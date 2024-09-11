
<div <?= ($controlled_by) ? 'controlled_by="' . $controlled_by . '" controlled_id="' . $controlled_id . '"' : ''; ?>
  class="bc_column <?php if (($num_row) % 2 == 0) : ?>erow<?php endif; ?>" col_name="<?= $db_name ?>">

  <p class="bc_column_header">
    <?= $display_as ?>:
  </p>

  <?php if (isset($col_info) && $col_info != "") : ?>
    <p class="bc_column_info">
      <i><?= $col_info ?></i>
    </p>
  <?php endif; ?>

  <div class="bc_column_input bc_col_text">
    <input class="ui-rounded1" <?= isset($placeholder) && $placeholder ? 'placeholder="' . $placeholder . '"' : '' ?> <?= $disabled ? 'disabled' : '' ?> type="text" name="col_<?= $db_name ?>" value="<?php if (isset($value)) : ?><?= $value; ?><?php endif; ?>">
  </div>

  <div class="bc_error_text"></div>

</div>

<br>